<?php


namespace Magenest\NotificationBox\Setup\Patch\Data;

use Magenest\NotificationBox\Helper\Helper;
use Magento\Framework\Filesystem\Io\File;
use Magenest\NotificationBox\Model\Notification;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;

class AddDefaultNotificationType implements DataPatchInterface
{
    /** @var string Notification icon directory url */
    const URL_ICON = 'notificationtype/icon';

    /** @var string default icon directory url */
    const URL_ICON_DEFAULT = '/view/adminhtml/web/images/defaultImage';

    /** @var Helper  */
    private $helper;

    /** @var StoreManagerInterface  */
    private $storeManagerInterface;

    /**
     * @var DirectoryList
     */
    protected $dir;
    /**
     * @var DriverInterface
     */
    protected $driverInterface;
    /**
     * @var File
     */
    protected $file;
    /**
     * @var ComponentRegistrarInterface
     */
    protected $path;
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * Construct
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param Helper $helper
     * @param StoreManagerInterface $storeManagerInterface
     * @param DirectoryList $dir
     * @param ComponentRegistrarInterface $path
     * @param DriverInterface $driverInterface
     * @param File $file
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        Helper $helper,
        StoreManagerInterface $storeManagerInterface,
        DirectoryList $dir,
        ComponentRegistrarInterface $path,
        DriverInterface $driverInterface,
        File $file
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->helper = $helper;
        $this->dir = $dir;
        $this->path = $path;
        $this->driverInterface = $driverInterface;
        $this->file = $file;
    }
    /**
     * Apply
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $rootPath = $this->path->getPath('module', 'Magenest_NotificationBox');
        //get media folder
        $rootPub = $this->dir->getPath('media');

        //create and authorize the notificationtype/icon directory
        if (!$this->file->fileExists($rootPub .'/'. self::URL_ICON)) {
            $this->driverInterface->createDirectory($rootPub .'/'. self::URL_ICON, 0777, true);
        }
        $filePath = $rootPath . self::URL_ICON_DEFAULT;
        $copyFileFullPath = $rootPub .'/'. self::URL_ICON;

        //copy folder images to pub/media folder
        $this->helper->copyDirectory($filePath, $copyFileFullPath);

        $currentStore = $this->storeManagerInterface->getStore();

        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . self::URL_ICON;

        $listDefaultImage = $this->helper->getDefaultImage();

        $data = [
            [
                'name' => Notification::ABANDONED_CART_REMINDS_LABEL,
                'description' => Notification::ABANDONED_CART_REMINDS_LABEL,
                'is_category' => 1,
                'default_type' => Notification::ABANDONED_CART_REMINDS,
                'icon' => '[{
                                "name": "'.Notification::ABANDONED_CART_REMINDS.'",
                                "type": "image/png",
                                "url": "'.$mediaUrl.$listDefaultImage[Notification::ABANDONED_CART_REMINDS].'",
                                "size":"1093"
                    }]'
            ],
            [
                'name' => Notification::ORDER_STATUS_UPDATE_LABEL,
                'description' => Notification::ORDER_STATUS_UPDATE_LABEL,
                'is_category' => 1,
                'default_type' => Notification::ORDER_STATUS_UPDATE,
                'icon' => '[{
                                "name": "'.Notification::ORDER_STATUS_UPDATE.'",
                                "type": "image/png",
                                "url": "'.$mediaUrl.$listDefaultImage[Notification::ORDER_STATUS_UPDATE].'",
                                "size":"1474"
                    }]'
            ],
            [
                'name' => Notification::REVIEW_REMINDERS_LABEL,
                'description' => Notification::REVIEW_REMINDERS_LABEL,
                'is_category' => 1,
                'default_type' => Notification::REVIEW_REMINDERS,
                'icon' => '[{
                                "name": "'.Notification::REVIEW_REMINDERS.'",
                                "type": "image/png",
                                "url": "'.$mediaUrl.$listDefaultImage[Notification::REVIEW_REMINDERS].'",
                                "size":"718"
                    }]'
            ]
        ];
        $this->moduleDataSetup->getConnection()->insertArray(
            $this->moduleDataSetup->getTable('magenest_notification_type'),
            ['name', 'description','is_category','default_type','icon'],
            $data
        );
        $this->moduleDataSetup->endSetup();
    }
    /**
     * Get aliases
     */
    public function getAliases()
    {
        return [];
    }
    /**
     * Get dependencies
     */
    public static function getDependencies()
    {
        return [];
    }
}
