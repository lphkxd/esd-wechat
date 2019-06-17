<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 18-12-30
 * Time: 下午9:43
 */

namespace ESD\Plugins\WeChat\OfficialAccount;

use ESD\Core\Server\Beans\Response;
use ESD\Plugins\WeChat\Exception\InvalidUrl;
use ESD\Plugins\WeChat\Bean\OfficialAccount\MediaRequest;
use ESD\Plugins\WeChat\Bean\OfficialAccount\MediaResponse;
use ESD\Plugins\WeChat\Bean\OfficialAccount\PostFile;
use ESD\Plugins\WeChat\Exception\OfficialAccountError;
use ESD\Plugins\WeChat\Exception\RequestError;
use ESD\Plugins\WeChat\Utility\HttpClient;
use Swoole\Coroutine;

/**
 * Class Media
 *
 * @package ESD\Plugins\WeChat\OfficialAccount
 */
class Media extends OfficialAccountBase
{

    /**
     * 上传临时素材
     * @param MediaRequest $mediaBean
     * @return array
     * @throws InvalidUrl
     * @throws MimeDetectorException
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function upload(MediaRequest $mediaBean)
    {
        $url = ApiUrl::generateURL(ApiUrl::MEDIA_UPLOAD, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken(),
            'TYPE'         => $mediaBean->getType()
        ]);

        return $this->uploadMedia($url, $this->crateFileBean($mediaBean));
    }

    /**
     * 获取临时素材
     * @param $mediaId
     * @return MediaResponse|mixed
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function get($mediaId)
    {
        $url = ApiUrl::generateURL(ApiUrl::MEDIA_GET, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken(),
            'MEDIA_ID'     => $mediaId
        ]);

        return $this->getMedia($url);
    }

    /**
     * 执行素材上传
     * @param string $url
     * @param PostFile $fileBean
     * @param array|null $form
     * @param int $timeout
     * @return array
     * @throws InvalidUrl
     * @throws RequestError
     */
    protected function uploadMedia(string $url, PostFile $fileBean, array $form = null, $timeout = 30): array
    {
        $response = HttpClient::uploadFileByPath($url, $fileBean->getPath(), $fileBean->getName(), $fileBean->getMimeType(), $fileBean->getFilename(), $fileBean->getOffset(), $fileBean->getLength(), $timeout, $form);
        $content = $response->getBody();
        $json = json_decode($content, true);

        // 解包失败认为请求出错
        if (!is_array($json)) {
            $ex = new RequestError();
            $ex->setResponse($response);
            throw $ex;
        }

        return $json;
    }

    /**
     * 获取微信素材
     * @param string $url
     * @param array|null $data
     * @return Response|MediaResponse
     * @throws OfficialAccountError
     * @throws InvalidUrl
     */
    protected function getMedia(string $url, array $data = null)
    {
        if (!is_null($data)) {
            $response = HttpClient::postJson($url, $data);
        } else {
            $response = HttpClient::get($url);
        }

        $response = new MediaResponse($response);
        if ($response->isJson()) {
            // if an exception is found, it is thrown
            $this->hasException(json_decode($response->getContent(), true));
        }
        return $response;
    }


    /**
     * 创建一个文件对象
     * @param MediaRequest $mediaBean
     * @return PostFile
     * @throws MimeDetectorException
     */
    protected function crateFileBean(MediaRequest $mediaBean): PostFile
    {
        $fileBean = new PostFile($mediaBean->toArray(null, MediaRequest::FILTER_NOT_EMPTY));
        $fileBean->setName('media');

        if (!is_null($fileBean->getPath())) {
            $fileBean->setData(Coroutine::readFile($fileBean->getPath()));
        }

        $fileBean->setFilename(basename($fileBean->getPath()));
        $fileBean->setMimeType(MimeType::getMimeTypeFromStream($fileBean->getData()));
        $fileBean->setFilename($fileBean->getFilename());

        return $fileBean;
    }
}