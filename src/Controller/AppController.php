<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

require_once(ROOT . DS. 'webroot' .DS. 's3' .DS. 'S3.php');

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use S3;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */

if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIFVEZSQLL26D2HYQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');
if (!defined('Bucket')) define('Bucket', 'zensilo');
if (!defined('BucketUrl')) define('BucketUrl', 'https://s3-us-west-2.amazonaws.com/');

class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function is_sub_domain() {
        $arr = explode(".", $_SERVER['HTTP_HOST']);
        return count($arr) == 3 ? $arr[0] : false;
    }

    public function is_localhost() {
        $whitelist = array( '127.0.0.1', '::1', );
        if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) || is_numeric(strpos($_SERVER['REMOTE_ADDR'], '192.168.1.')))
            return true;
    }

    public function send_email($template, $to, $subject, $vars, $from='krishc@zenstill.com', $from_name='Zensilo')
    {
        if($this->is_localhost())
            return;

        $email = new Email();
        $email->template($template)
            ->emailFormat('html')
            ->to($to)
            ->from($from, $from_name)
            ->subject($subject)
            ->set($vars)
            ->send();
    }

    public function sendNotificaion($from, $to, $type, $project_id = 0, $task_id = 0, $notes, $company_id)
    {
        $this->Notification = TableRegistry::get('notifications');

        $data = array('from' => $from, 'to' => $to, 'type' => $type, 'project_id' => $project_id, 'task_id' => $task_id, 'notes' => $notes, 'status' => 0);

        $mdata = $this->Notification->newEntity();
        $mdata = $this->Notification->patchEntity($mdata, $data);
        $this->Notification->save($mdata);
    }

    public function s3upload($tmp, $filename)
    {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $headers = array(
                    'Cache-Control' => 'max-age=31536000', 
                    'Expires'       => gmdate('D, d M Y H:i:s GMT', time() + (365 * 24 * 60 * 60))
                );

        $filename = str_replace(" ", "_", $filename);
        if($s3->putObjectFile($tmp, Bucket , $filename, S3::ACL_PUBLIC_READ, $headers))
            return BucketUrl.Bucket.'/'.$filename;
        else
            return false;
    }
}
