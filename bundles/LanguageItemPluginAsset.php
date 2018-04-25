<?php

namespace lajax\translatemanager\bundles;

use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;

/**
 * LanguageItem Plugin asset bundle
 * 
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */
class LanguageItemPluginAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@lajax/translatemanager/assets';

    /**
     * @inheritdoc
     */
    public function init() {

        $this->sourcePath = \Yii::$app->getModule('translatemanager')->getLanguageItemsDirPath();
        $sourceTranslationFile = \Yii::getAlias($this->sourcePath . \Yii::$app->language . '.js');

        if (file_exists($sourceTranslationFile)) {

            $publishPath = \Yii::$app->assetManager->getPublishedPath($this->sourcePath);
            $publishedTranslationFile = $publishPath . DIRECTORY_SEPARATOR . \Yii::$app->language . '.js';

            if ($publishPath === false ||
                !file_exists($publishedTranslationFile) ||
                (filemtime($sourceTranslationFile) > filemtime($publishedTranslationFile))
            ){
                $this->publishOptions = ArrayHelper::merge($this->publishOptions, ['forceCopy' => true]);
            }

            $this->js = [
                \Yii::$app->language . '.js'
            ];
        } else {
            $this->sourcePath = null;
        }

        parent::init();
    }

}
