<?php
namespace Magenest\NotificationBox\Controller\Adminhtml\Upload;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\Store\Model\StoreManagerInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magenest\NotificationBox\Logger\Logger;

/**
 * Class Uploads
 * Magenest\Ticket\Controller\Adminhtml\Template
 */
class Upload extends \Magento\Backend\App\Action
{
    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Database
     */
    protected $coreFileStorageDatabase;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Uploads constructor.
     *
     * @param Context $context
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Logger $logger
     * @param Database $coreFileStorageDatabase
     */
    public function __construct(
        Action\Context $context,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        Logger $logger,
        Database $coreFileStorageDatabase
    ) {
        parent::__construct($context);
        $this->filesystem              = $filesystem;
        $this->uploaderFactory         = $uploaderFactory;
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->storeManager            = $storeManager;
        $this->logger                  = $logger;
    }

    /**
     * Upload file controller action
     *
     * @return ResultInterface
     */

    public function execute()
    {
        $files = $this->getRequest()->getFiles();
        if (isset($files['image'])) {
            $background['icon'] = $files['image'];
        }
        if (isset($files['icon'])) {
            $background['icon'] = $files['icon'];
        }

        if (isset($background)) {
            try {
                $result           = $this->saveBackground($background['icon']);
                $result['cookie'] = [
                'name'     => $this->_getSession()->getName(),
                'value'    => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path'     => $this->_getSession()->getCookiePath(),
                'domain'   => $this->_getSession()->getCookieDomain(),
                ];
            } catch (Exception $e) {
                $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
            }
        }
        if (empty($result)) {
            $result = ['error' => 'Image not found'];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }

    /**
     * Get file path
     *
     * @param string $path
     * @param string $imageName
     *
     * @return string
     */
    public function getFilePath($path, $imageName)
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }

    /**
     * Save background
     *
     * @param string $files
     *
     * @return array
     * @throws Exception
     * @throws LocalizedException
     */
    public function saveBackground($files)
    {
        $path     = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)
            ->getAbsolutePath(
                'notificationtype/icon'
            );
        $uploader = $this->uploaderFactory->create(['fileId' => $files]);
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
        $uploader->setAllowRenameFiles(true);
        $result = $uploader->save($path);
        if (!$result) {
            throw new LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        /**
         * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
         */
        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['path']     = str_replace('\\', '/', $path);

        $result['url']  = $this->storeManager
                ->getStore()
                ->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $this->getFilePath('notificationtype/icon', $result['file']);
        $result['name'] = $result['file'];

        if (isset($result['file'])) {
            try {
                $relativePath = rtrim('notificationtype/icon', '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (Exception $e) {
                $this->logger->critical($e);
                throw new LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }

        return $result;
    }
    /**
     * ACL
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_NotificationBox::notification_type');
    }
}
