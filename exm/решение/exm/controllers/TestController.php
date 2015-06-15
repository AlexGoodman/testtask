<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Smsc;
use app\models\Phone;


class TestController extends Controller{


    // The better way is to put this function into some helper class
    protected function startSession(){
        $session = Yii::$app->session;
        if ($session->isActive) {
            $session->open();
        }
        return $session;
    }

    protected function isPhoneVerified($phone){
        $count = (new \yii\db\Query()) -> from('phone')->where(['phone' => $phone])->count();
        if($count){
            $msg = ['success' => 'This phone number is verified already'];
            echo json_encode($msg);
            return true;
        }
    }


    public function actionIndex(){
        return $this->render('index');
    }


    public function actionSms(){
        $request = Yii::$app->request;
        if($request -> isPost && $request -> isAjax) {

            $post = $request->post();
            $smsc = new Smsc;
            $smsc -> attributes  = $post;

            if($smsc ->validate()){
                $phone = str_replace(['+', '(', ')'], '', $post['phone']);

                if(!$this -> isPhoneVerified($phone)){
                    $vcode = rand(10, 99) . '-' . rand(10, 99) . '-' . rand(10, 99) . '-' . rand(10, 99);
                    $data = $smsc->send_sms($phone, $vcode);

                    $session = $this -> startSession();
                    $session['phone'] = $phone;
                    $session['vcode'] = $vcode;
                    $session->close();

                    $msg = ['success' => 'The verification code have been sent'];
                    echo json_encode($msg);
                }
            }
            else{
                $msg = ['success' => false, 'error' => 'Wrong number'];
                echo json_encode($msg);
            }
        }
    }


    public function actionVphone(){
        $request = Yii::$app->request;

        if($request -> isPost && $request -> isAjax) {
            $post = $request->post();
            $vphone = new Phone();
            $vphone -> setAttributes($post);

            if($vphone ->validate()){
                $phone = str_replace(['+', '(', ')'], '', $post['phone']);

                if(!$this -> isPhoneVerified($phone)){
                    $session = $this -> startSession();

                    if (
                        $session['phone']
                        && $session['vcode']
                        && $phone == $session['phone']
                        && $post['vcode'] == $session['vcode']
                    ) {
                        $vphone -> __set('phone', $phone);
                        $vphone -> save(false);
                        $session->destroy();
                        $msg = ['success' => 'The phone number have been verified'];
                        echo json_encode($msg);
                    }
                    else {
                        $session->close();
                        $msg = ['success' => false, 'error' => 'Wrong verification code'];
                        echo json_encode($msg);
                    }
                }
            }
            else{
                $msg = ['success' => false, 'error' => 'Wrong number'];
                echo json_encode($msg);
            }
        }
    }
}
