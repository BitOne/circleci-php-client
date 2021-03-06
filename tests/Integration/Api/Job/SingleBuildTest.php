<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Job;

use Jmleroux\CircleCi\Api\Job\SingleBuild;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\JobDetails;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class SingleBuildTest extends TestCase
{
    use ExecuteWithRetryTrait;

    public function testQueryOk()
    {
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personaltoken, 'v1.1');
        $query = new SingleBuild($client);
        $build = $this->executeWithRetry($query, ['github', 'jmleroux', 'circleci-php-client', 50]);
        $this->assertInstanceOf(JobDetails::class, $build);
        $this->assertEquals(50, $build->buildNum());
    }
}
