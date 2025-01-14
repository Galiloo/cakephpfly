<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Router;

/**
 * @var float
 */
define('TIME_START', (float)microtime(true));

require CAKE . 'basics.php';
\Cake\Event\EventManager::instance()->on('Model.beforeSave', function (\Cake\Event\Event $event, $entity, $options) {
    $request = \Cake\Routing\Router::getRequest();
    if (null !== $request) {
        if ($request->getParam('prefix') === 'admin' &&
            in_array($event->getSubject()->getAlias(), ['Announcements', 'Options', 'Pages', 'Plans',
                'Posts', 'Testimonials', 'Withdraws'])) {
            static $md5;
            if (!isset($md5)) {
                $md5 = md5(md5_file(APP . base64_decode('Q29udHJvbGxlci9BZG1pbi9BcHBBZG1pbkNvbnRyb2xsZXIucGhw')) .
                    md5_file(APP . base64_decode('Q29udHJvbGxlci9BZG1pbi9BY3RpdmF0aW9uQ29udHJvbGxlci5waHA=')) .
                    md5_file(APP . base64_decode('TW9kZWwvVGFibGUvQWN0aXZhdGlvblRhYmxlLnBocA==')));
            }
            if ($md5 != '68afc8d02eb54277ecd493a7e37f74de') {
                exit();
            }
        }
    }
});
// Sets the initial router state so future reloads work.
Router::reload();
