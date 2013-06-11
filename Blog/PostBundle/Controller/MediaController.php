<?php
namespace Zertz\Blog\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaController extends Controller
{
    public function uploadAction(Request $request, $providerName = 'sonata.media.provider.image')
    {
        if ($request->get('CKEditor')) {
            $file = $request->files->get('upload');
        
            $funcNum = $request->get('CKEditorFuncNum');

            $postId = $request->get('postId');
            $post = $this->getDoctrine()->getRepository('ZertzBlogPostBundle:Post')->findById($postId);

            $url = '';
            $message = 'Post could not be found';
            $status = 500;
            
            if ($post) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    try {
                        /** @var $mediaManager \Sonata\MediaBundle\Admin\Manager\DoctrineORMManager */
                        $mediaManager = $this->get('sonata.media.manager.media');

                        /** @var $mediaAdmin \Sonata\MediaBundle\Admin\ORM\MediaAdmin */
                        $mediaAdmin = $this->get('sonata.media.admin.media');

                        /** @var $provider \Sonata\MediaBundle\Provider\MediaProviderInterface */
                        $provider = $this->get($providerName);

                        $context = $mediaAdmin->getPool()->getDefaultContext();

                        $mediaClass = $mediaAdmin->getClass();

                        /** @var $media \Sonata\MediaBundle\Model\MediaInterface */
                        $media = new $mediaClass();

                        $media->setProviderName($provider->getName());

                        $media->setContext($context);

                        $media->setEnabled(true);

                        $media->setName($file->getClientOriginalName());

                        $media->setBinaryContent($file);
                        $mediaManager->save($media);

                        $path = $provider->generatePublicUrl($media, 'reference');

                        // Check the $_FILES array and save the file. Assign the correct path to a variable ($url).
                        $url = $path;
                        // Usually you will only assign something here if the file could not be uploaded.
                        $message = '';

                        $status = 200;
                    } catch (\Exception $e) {
                        $message = $e->getMessage();
                    }
                } else if ($file instanceof UploadedFile && !$file->isValid()) {
                    $message = 'invalid file';
                } else {
                    $message = 'wrong file size';
                }
            }

            $response = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";

            return new Response($response, $status);
        }
        
        return new Response('Not CKEditor');
    }
    
    public function ckeditorUploadAction(Request $request, $providerName = 'sonata.media.provider.image')
    {
        
    }
}
