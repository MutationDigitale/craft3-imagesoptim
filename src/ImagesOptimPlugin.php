<?php

namespace mutation\imagesoptim;

use craft\base\Plugin;
use craft\events\GenerateTransformEvent;
use craft\services\AssetTransforms;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use yii\base\Event;

class ImagesOptimPlugin extends Plugin
{
    /**
     * @var ImagesOptimPlugin
     */
    public static $plugin;

    public function init()
    {
        parent::init();

        self::$plugin = $this;

        $this->initEvents();
    }

    protected function initEvents()
    {
        Event::on(
            AssetTransforms::class,
            AssetTransforms::EVENT_GENERATE_TRANSFORM,
            function (GenerateTransformEvent $event) {
                $tempFilename = uniqid(pathinfo($event->transformIndex->filename, PATHINFO_FILENAME), true) .
                    '.' . $event->transformIndex->detectedFormat;
                $tempPath = \Craft::$app->getPath()->getTempPath() . DIRECTORY_SEPARATOR . $tempFilename;
                $event->image->saveAs($tempPath);

                $optimizerChain = OptimizerChainFactory::create();
                $optimizerChain->optimize($tempPath);

                $event->tempPath = $tempPath;
            }
        );
    }
}
