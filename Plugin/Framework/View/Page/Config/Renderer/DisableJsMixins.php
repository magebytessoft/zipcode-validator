<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Plugin\Framework\View\Page\Config\Renderer;

use Magebytes\ZipCodeValidator\Model\ZipCode as ZipCodeProvider;
use Magento\Framework\View\Asset\GroupedCollection;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Page\Config\Renderer;
use Magebytes\ZipCodeValidator\Helper\Data;

class DisableJsMixins
{
    /**
     * @var Repository
     */
    private $assetRepo;

    /**
     * @var GroupedCollection
     */
    private $pageAssets;

    /**
     * @var ZipCodeProvider
     */
    private $zipCodeConfig;

    /**
     * @var Data
     */
    private $dataHelper;

    public function __construct(
        ZipCodeProvider $zipCodeConfig,
        Repository $assetRepo,
        Data $dataHelper,
        GroupedCollection $pageAssets
    ) {
        $this->zipCodeConfig = $zipCodeConfig;
        $this->assetRepo = $assetRepo;
        $this->dataHelper = $dataHelper;
        $this->pageAssets = $pageAssets;
    }

    /**
     * Disable Magebytes ZipCodeValidator js mixins if module is disabled
     *
     * @param Renderer $subject
     * @param array $resultGroups
     * @return array
     */
    public function beforeRenderAssets(Renderer $subject, $resultGroups = [])
    {
        if (!$this->getStatus()) {
            $file = 'Magebytes_ZipCodeValidator::js/magebytesZipodevalidatorDisabled.js';
            $asset = $this->assetRepo->createAsset($file);
            $this->pageAssets->insert($file, $asset, 'requirejs/require.js');
            return [$resultGroups];
        }
        return [$resultGroups];
    }

    /**
     * @return mixed
     */
    public function getStatus(){
    	return $this->dataHelper->getIsActive();
    }
}
