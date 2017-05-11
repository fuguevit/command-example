<?php

namespace Fuguevit\Command;

use OSS\Core\OssException;
use OSS\OssClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OssUploader extends Command
{
    const accessKeyId = "put access key here";
    const accessKeySecret = "put access key secret here";

    const endPoint = "oss-cn-beijing.aliyuncs.com";
    const bucket = "put bucket here";

    protected function configure()
    {
        $this->setName('oss-upload')
            ->setDescription('Upload file to OSS.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $ossClient = new OssClient(self::accessKeyId, self::accessKeySecret, self::endPoint);

            for ($i=1; $i<943; $i++) {
                $url = "http://cdn-zx.17zuoye.cn/img/avatar/{$i}.jpg";
                $content = file_get_contents($url);
                $output->writeln($url);
                $ossClient->putObject(self::bucket, "img/avatar/r/{$i}.jpg", $content);
            }

            $output->writeln('success');
        } catch (OssException $e) {
            $output->writeln($e->getMessage());
        }

    }
}