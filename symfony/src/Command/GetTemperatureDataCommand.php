<?php

namespace App\Command;

use App\Entity\TemperatureResponse;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetTemperatureDataCommand extends Command {
    protected static $defaultName = 'app:get-temperature-data';
    protected static $defaultDescription = 'Get the api temperature data and persist it to the database';
    /**
     * @var string
     */
    private $temperatureApi;

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var HttpClient
     */
    private $client;

    protected function configure(): void {
        $this
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Pull the api data but do not persist it to the database');
    }

    public function __construct(HttpClientInterface $client, EntityManagerInterface $manager, KernelInterface $kernel) {
        $this->client = $client;
        $this->manager = $manager;
        $this->temperatureApi = $kernel->getContainer()->getParameter('temperature_api');
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);
        $this->dryRun = $input->getOption('dry-run');

        try {
            $response = $this->client->request('GET', $this->temperatureApi);
            $body = $response->toArray();
        } catch (ClientExceptionInterface | DecodingExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            $io->error('Unable to get response: ' . $e->getMessage());
            return Command::FAILURE;
        }

        if (!$this->dryRun) {
            $temperatureResponse = new TemperatureResponse();
            $temperatureResponse
                ->setResponse($body)
                ->setCelsius(self::getCelsiusFromBody($body))
                ->setRelativeHumidity(self::getRelativeHumidityFromBody($body));
            try {
                $this->manager->persist($temperatureResponse);
                $this->manager->flush();
                $this->manager->clear();
            } catch (ORMException | OptimisticLockException | MappingException $e) {
                $io->error('Unable to persist temperature response: ' . $e->getMessage());
                return Command::FAILURE;
            }
        } else {
            $io->comment('Response Body');
            dump([
                'body'     => $body,
                'celsius'  => self::getCelsiusFromBody($body),
                'humidity' => self::getRelativeHumidityFromBody($body),
            ]);
        }

        return Command::SUCCESS;
    }

    public static function getCelsiusFromBody(array $responseBody): float {
        $result = 0.0;
        if (isset($responseBody['temperature']['celsius']['value'])) {
            $result = (float)$responseBody['temperature']['celsius']['value'];
        }
        return $result;
    }

    public static function getRelativeHumidityFromBody(array $responseBody): float {
        $result = 0.0;
        if (isset($responseBody['humidity']['relative']['value'])) {
            $result = (float)$responseBody['humidity']['relative']['value'];
        }
        return $result;
    }
}
