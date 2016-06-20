<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\User;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserAddress;
use app\models\Product;
use app\models\Manufacturer;
use app\models\ManufacturerAddress;
use app\models\Repository;
use app\models\AddProductForm;
use app\models\AddManufacturerForm;
use app\models\Region;
use app\models\AddRepository;
use app\models\RepositoryAddress;
use app\models\Order;
use app\models\OrderDetail;
use app\models\AddOrderForm;
use app\models\Client;
use app\models\AddClientForm;
use app\models\ClientAddress;
use app\models\Purchase;
use app\models\PurchaseDetail;
use app\models\AddPurchaseForm;
use app\models\Dispatch;
use app\models\DispatchDetail;
use app\models\AddDispatchForm;
use app\models\NotOrderBillForm;
use app\models\NotPurchaseBillForm;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        } else {
            $userAddress = UserAddress::findOne(['user_address_id', \Yii::$app->user->identity->user_address_id]);
            $products = Product::find()->all();
            return $this->render('index', ['products' => $products]);
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/site/login']);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionManufacturer()
    {
        $manufacturers = Manufacturer::find()->all();

        return $this->render('manufacturer', ['manufacturers' => $manufacturers]);
    }

    public function actionRepository()
    {
        $repositories = Repository::find()->all();

        return $this->render('repository', ['repositories' => $repositories]);
    }

    public function actionClient()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $clients = Client::find()->all();
        return $this->render('client', ['clients' => $clients]);
    }

    public function actionPrint() {
        $level = array('无', '甲', '乙', '丙');
        $grade = array('无', '一', '二', '三');
        $id = $_REQUEST['client_id'];
        $client = Client::find()->where(["client_id"=>"$id"])->one();
        $printerinfo['client_id']              = $id;
        $printerinfo['client_name']            = $client['client_name'];
        $printerinfo['client_alias']           = $client['client_alias'];
        $printerinfo['client_contact']         = $client['client_contact'];
        $printerinfo['client_address_id']      = $client['client_address_id'];
        $printerinfo['client_type']            = $client['client_type'];
        $printerinfo['client_tel']             = $client['client_tel'];
        $printerinfo['client_email']           = $client['client_email'];
        $printerinfo['client_bank_account']    = $client['client_bank_account'];
        $printerinfo['client_memo']            = $client['client_memo'];
        $printerinfo['client_bussiness_info']  = $client['client_bussiness_info'];
        $printerinfo['client_level']           = $level[ $client['client_level'] ];
        $printerinfo['client_grade']           = $grade[ $client['client_grade'] ];
        $resp = $printerinfo;
        echo json_encode($resp);
        exit();
    }

    public function actionAddproduct()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $model = new AddProductForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $product = new Product();
            $product->product_name          = $model->name;
            $product->product_chemical_name = $model->chemical_name;
            $product->product_specification = $model->specification;
            $product->client_manufacture_id = intval($model->manufacturer);
            $product->client_supplier_id    = intval($model->suppliers);
            $product->client_channel_id     = intval($model->repositories);
            $product->purchase_price        = $model->purchasePrice;
            $product->purchase_unit_price   = $model->purchaseUnitPrice;
            $product->retail_price          = $model->retailPrice;
            $product->retail_unit_price     = $model->retailUnitPrice;
            $product->trade_price           = $model->tradePrice;
            $product->trade_unit_price      = $model->tradeUnitPrice;
            $product->product_validity      = $model->validity;
            $rand = time() . rand(1000, 9999);
            $model->file->saveAs('./../upload/' . $rand . $model->file->name);
            $product->file = 'http://localhost/medical/upload/' . $rand . $model->file->name;
            //var_dump($product->file);exit();
            $product->save();
            return $this->redirect(['site/index']);
        } else {
            $manufacturerDatabases = Client::find()->where(['client_type'=>'生产厂商'])->all();
            $manufacturers = [];
            foreach ($manufacturerDatabases as $manufacture) {
                $manufacturers[$manufacture->client_id] = $manufacture->client_name;
            }

            $repositoryDatabases = Client::find()->where(['client_type'=>'流通商'])->all();
            $repositories = [];
            foreach ($repositoryDatabases as $repository) {
                $repositories[$repository->client_id] = $repository->client_name;
            }

            $supplierDatabases = Client::find()->where(['client_type'=>['供应商', '生产厂商', '流通商']])->all();
            $suppliers = [];
            foreach ($supplierDatabases as $supplier) {
                $suppliers[$supplier->client_id] = $supplier->client_name;
            }

            return $this->render('addProduct', ['model' => $model, 'manufacturers' => $manufacturers, 'repositories' => $repositories, 'suppliers' => $suppliers]);
        }
    }

    public function actionAddmanufacturer()
    {
        $model = new AddManufacturerForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $address = new ManufacturerAddress();
            $address->region_province_id   = $model->regionProvince;
            $address->region_city_id       = $model->regionCity;
            $address->region_country_id    = $model->regionCountry;
            $address->manufacturer_address = $model->detailAddress;
            $address->save();
            $manufacturer = new Manufacturer();
            $manufacturer->manufacturer_name = $model->name;
            $manufacturer->manufacturer_address_id = $address->manufacturer_address_id;
            $manufacturer->save();

            return $this->redirect(['/site/manufacturer']);
        } else {
            $regionProvinces = Region::getProvices();

            return $this->render('AddManufacturer', ['model' => $model, 'regionProvinces' => $regionProvinces]);
        }
    }

    public function actionAddclient()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $level = array('无', '甲', '乙', '丙');
        $grade = array('无', '一', '二', '三');
        $model = new AddClientForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $address = new ClientAddress();
            $address->region_province_id = $model->regionProvince;
            $address->region_city_id = $model->regionCity;
            $address->region_country_id = $model->regionCountry;
            $address->client_address = $model->detailAddress;
            $address->save();
            $client = new Client();
            $client->client_name            = $model->name;
            $client->client_alias           = $model->alias;
            $client->client_address_id      = $address->client_address_id;
            $client->client_contact         = $model->contact;
            $client->client_type            = $model->type;
            $client->client_tel             = $model->tel;
            $client->client_email           = $model->email;
            $client->client_bank_account    = $model->bank_account;
            $client->client_memo            = $model->memo;
            $client->client_bussiness_info  = $model->bussiness_info;
            $client->client_level           = $model->level;
            $client->client_grade           = $model->grade;
            $client->save();

            return $this->redirect(['/site/client']);
        } else {
            $regionProvinces = Region::getProvices();

            return $this->render('addClient', ['model' => $model, 'regionProvinces' => $regionProvinces]);
        }
    }

    public function actionGetregion()
    {
        if (isset(Yii::$app->request->post()['parentId'])) {
            $parentId = Yii::$app->request->post()['parentId'];
            $regions = Region::getRegionByParent($parentId);
            echo json_encode($regions, JSON_UNESCAPED_UNICODE);
        }
    }

    public function actionGetclient()
    {
        $clientType = Yii::$app->request->post()['clientType'];
        $clientProvince = Yii::$app->request->post()['clientProvince'];
        $regions = Region::getClientByType($clientType, $clientProvince);
        //var_dump($regions);exit();
        echo json_encode($regions, JSON_UNESCAPED_UNICODE);
    }

    public function actionAddrepository()
    {
        $model = new AddRepository();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $address = new RepositoryAddress();
            $address->region_province_id = $model->regionProvince;
            $address->region_city_id = $model->regionCity;
            $address->region_country_id = $model->regionCountry;
            $address->repository_address = $model->detailAddress;
            $address->save();
            $repository = new Repository();
            $repository->repository_address_id = $address->repository_address_id;
            $repository->repository_name = $model->name;
            $repository->repository_contact_name = $model->contactName;
            $repository->repository_contact_call = $model->contactCall;
            $repository->save();

            return $this->redirect(['site/repository']);
        } else {
            $regionProvinces = Region::getProvices();

            return $this->render('addRepository', ['model' => $model, 'regionProvinces' => $regionProvinces]);
        }
    }

    public function actionOrder()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $orders = Order::find()->where(['is_dispatch'=>'0'])->all();
        $orderDetails = [];
        foreach ($orders as $order) {
            $orderDetail = OrderDetail::find()->where(['order_id' => $order->order_id])->all();
            $orderStruct['order'] = $order;
            $orderStruct['detail'] = $orderDetail;
            array_push($orderDetails, $orderStruct);
        }
        return $this->render('order', ['orders' => $orderDetails]);
    }

    public function actionOrderdetail() {
        $order_id = $_REQUEST['order_id'];
        $orderDetail = OrderDetail::find()->where(['order_id' => $order_id])->all();
        $order_detail = [];
        foreach ($orderDetail as $v) {
            $purchase_detail        = PurchaseDetail::find()->where(['purchase_detail_id' => $v->product_id])->one();
            $purchase_batch         = Purchase::find()->where(['purchase_id' => $purchase_detail->purchase_id])->one()->purchase_batch;
            $product_name           = Product::find()->where(['product_id' => $purchase_detail->product_id])->one()->product_name;
            $product_chemical_name  = Product::find()->where(['product_id' => $purchase_detail->product_id])->one()->product_chemical_name;
            $manufacture_id         = Product::find()->where(['product_id' => $purchase_detail->product_id])->one()->client_manufacture_id;
            $manufacture_name       = Client::find()->where(['client_id' => $manufacture_id])->one()->client_name;
            $orderStruct['product_name']              = $product_name;
            $orderStruct['product_chemical_name']     = $product_chemical_name;
            $orderStruct['manufacture_name']          = $manufacture_name;
            $orderStruct['product_num']               = $v->product_num;
            $orderStruct['order_detail_total_money']  = $v->order_detail_total_money;
            $orderStruct['product_channel_cost']      = $v->product_channel_cost;
            $orderStruct['product_profit']            = $v->product_profit;
            $orderStruct['total_accounts']            = $v->total_accounts;
            $orderStruct['product_batch']             = $purchase_batch;
            array_push($order_detail, $orderStruct);
        }
        $resp = $order_detail;
        echo json_encode($resp);
        exit();
    }

    public function actionPurchase()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $purchases = Purchase::find()->where(['is_dispatch'=>'0'])->all();
        $purchaseDetails = [];
        foreach ($purchases as $purchase) {
            $purchaseDetail = PurchaseDetail::find()->where(['purchase_id' => $purchase->purchase_id])->all();
            $purchaseStruct['order'] = $purchase;
            $purchaseStruct['detail'] = $purchaseDetail;
            array_push($purchaseDetails, $purchaseStruct);
        }
        return $this->render('purchase', ['purchases' => $purchaseDetails]);
    }

    public function actionPurchasedetail() {
        $purchase_id = $_REQUEST['purchase_id'];
        $purchaseDetail = PurchaseDetail::find()->where(['purchase_id' => $purchase_id])->all();
        $purchase_detail = [];
        foreach ($purchaseDetail as $v) {
            $purchase_batch = Purchase::find()->where(['purchase_id' => $purchase_id])->one()->purchase_batch;
            $product = Product::find()->where(['product_id' => $v->product_id])->one();
            $manufacture_name = Client::find()->where(['client_id' => $product->client_manufacture_id])->one()->client_name;
            $supplier_name = Client::find()->where(['client_id' => $v->client_supplier_id])->one()->client_name;
            $channel_name = Client::find()->where(['client_id' => $v->client_channel_id])->one()->client_name;

            $purchaseStruct['purchase_batch'] = $purchase_batch;
            $purchaseStruct['manufacture_name'] = $manufacture_name;
            $purchaseStruct['product_name'] = $product->product_name;
            $purchaseStruct['product_chemical_name'] = $product->product_chemical_name;
            $purchaseStruct['supplier_name'] = $supplier_name;
            $purchaseStruct['channel_name'] = $channel_name;
            $purchaseStruct['price'] = $v->price;
            $purchaseStruct['product_num'] = $v->product_num;
            $purchaseStruct['product_residue_num'] = $v->product_residue_num;
            $purchaseStruct['purchase_detail_total_money'] = $v->purchase_detail_total_money;
            array_push($purchase_detail, $purchaseStruct);
        }
        $resp = $purchase_detail;
        //var_dump($resp);
        echo json_encode($resp);
        exit();
    }

    public function actionDispatch()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $dispatchs = Order::find()->where(['is_dispatch'=>'1'])->all();
        $dispatchDetails = [];
        foreach ($dispatchs as $dispatch) {
            $purchaseDetail = OrderDetail::find()->where(['order_id' => $dispatch->order_id])->all();
            $dispatchStruct['order'] = $dispatch;
            $dispatchStruct['detail'] = $purchaseDetail;
            array_push($dispatchDetails, $dispatchStruct);
        }

        return $this->render('dispatch', ['dispatchs' => $dispatchDetails]);
    }

    public function actionAddorder()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $model = new AddOrderForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $order = new Order();
            $order->order_status = 0;
            $order->order_total_money = 0;
            $order->order_batch = $model->productBatch;
            $order->client_id = $model->client;
            $order->client_recommand_id = $model->recommandClient;
            $order->order_bill_code = $model->purchaseBillCode;
            $order->save();
            $totalMoney = 0;
            $len = count($model->productId);
            for ($i = 0; $i < $len; ++$i) {
                $productId = intval($model->productId[$i]);
                $productNum = intval($model->productNum[$i]);
                $productPrice = intval($model->productPrice[$i]);
                if ($productNum > 0) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->order_id;
                    $orderDetail->product_id = $productId;
                    $orderDetail->product_num = $productNum;
                    $orderDetail->product_price = $productPrice;
                    $purchaseDetail = PurchaseDetail::find()->where(['purchase_detail_id' => $productId])->one();
                    if($model->productChannelCost[$i]==null) {
                        $orderDetail->product_channel_cost = $productPrice/1.17 * 0.03;
                    } else {
                        $orderDetail->product_channel_cost = $model->productChannelCost[$i];
                    }
                    if($model->productProfit[$i]==null) {
                        $orderDetail->product_profit = (intval($orderDetail->product_price) - intval($purchaseDetail->price))/1.17 - ($productPrice/1.17 * 0.03);
                    } else {
                        $orderDetail->product_profit = $model->productProfit[$i];
                    }
                    if($model->totalAccounts[$i]==null) {
                        $orderDetail->total_accounts = $productPrice + $orderDetail->product_profit;
                    } else {
                        $orderDetail->total_accounts = $model->totalAccounts[$i];
                    }

                    $orderDetail->order_detail_total_money = $orderDetail->product_price * $productNum;
                    $orderDetail->save();
                    $purchaseDetail->product_residue_num = $purchaseDetail->product_residue_num - $productNum;
                    $purchaseDetail->save();
                    $totalMoney = $totalMoney + $orderDetail->order_detail_total_money;
                }
            }
            $db = \Yii::$app->db->createCommand();
            $db->update('order', ['order_total_money'=>$totalMoney], "order_id=:order_id", [':order_id'=>$order->order_id])->execute();
            return $this->redirect(['site/order']);
        } else {
            $userAddress = UserAddress::findOne(['user_address_id', \Yii::$app->user->identity->user_address_id]);
            $purchases = Purchase::find()->all();
            $purchaseDetails = [];
            foreach ($purchases as $purchase) {
                $purchaseDetail = PurchaseDetail::find()->where(['purchase_id' => $purchase->purchase_id])->all();
                $purchaseStruct['order'] = $purchase;
                $purchaseStruct['detail'] = $purchaseDetail;
                array_push($purchaseDetails, $purchaseStruct);
            }
            $clientDb = Client::find()->all();
            $clients = [];
            foreach ($clientDb as $client) {
                $clients['name'][$client->client_id] = $client->client_name;
                if($client->client_type != '生产厂商' && $client->client_type != '供应商') {
                    $clients['type'][$client->client_type] = $client->client_type;
                }
                $clients['recommand_type'][$client->client_type] = $client->client_type;
            }
            $provinceDb = region::find()->where(['region_parent_id'=>1])->all();
            foreach ($provinceDb as $v) {
                $province[$v['region_id']] = $v['region_name'];
            }

            return $this->render('addOrder', ['products' => $purchaseDetails, 'model' => $model, 'clients' => $clients, 'province' => $province]);
        }
    }

    public function actionOrdercart() {
        $purchase_detail_id = $_REQUEST['product_id'];
        $purchase_detail = PurchaseDetail::find()->where(['purchase_detail_id' => $purchase_detail_id])->one();
        $resp['batch'] = Purchase::find()->where(['purchase_id' => $purchase_detail['purchase_id']])->one()['purchase_batch'];
        $resp['product_residue_num'] = $purchase_detail->product_residue_num;
        $product = Product::find()->where(['product_id' => $purchase_detail['product_id']])->one();
        $resp['product_name'] = $product['product_name'];
        $resp['product_chemical_name'] = $product['product_chemical_name'];
        $resp['manufacture'] = Client::find()->where(['client_id' => $product['client_manufacture_id']])->one()['client_name'];
        //var_dump($resp);exit();
        echo json_encode($resp);
        exit();
    }

    public function actionCompute() {
        $productID = $_REQUEST['purchase_detail_id'];
        $price = intval($_REQUEST['price']);
        $num = intval($_REQUEST['num']);
        $compute['cost'] = $price/1.17*0.03*$num;
        $purchaseDetail = PurchaseDetail::find()->where(['purchase_detail_id' => $productID])->one();
        $compute['profit'] = ($price - $purchaseDetail->price)/1.17*$num - $compute['cost'];
        $compute['accounts'] = $purchaseDetail->price + $compute['profit'];
        $resp = $compute;
        echo json_encode($resp);
        exit();
    }

    public function actionAddpurchase()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $model = new AddPurchaseForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $purchase = new Purchase();
            $purchase->purchase_status = 0;
            $purchase->purchase_total_money = 0;
            $purchase->save();
            $totalMoney = 0;
            $len = count($model->productId);
            for ($i = 0; $i < $len; ++$i) {
                $productId = intval($model->productId[$i]);
                $productNum = intval($model->productNum[$i]);
                $productPrice = intval($model->productPrice[$i]);
                $supplier = intval($model->supplier[$i]);
                $channel = intval($model->channel[$i]);

                if ($productNum > 0) {
                    $purchaseDetail = new PurchaseDetail();
                    $purchaseDetail->purchase_id = $purchase->purchase_id;
                    $purchaseDetail->product_id = $productId;
                    $purchaseDetail->product_num = $productNum;
                    $purchaseDetail->price = $productPrice;
                    $purchaseDetail->client_supplier_id = $supplier;
                    $purchaseDetail->client_channel_id = $channel;
                    $purchaseDetail->product_residue_num = $productNum;
                    $product = Product::find()->where(['product_id' => $productId])->one();
                    $purchaseDetail->purchase_detail_total_money = $productPrice * $productNum;
                    $totalMoney = $totalMoney + $purchaseDetail->purchase_detail_total_money;
                    $purchaseDetail->save();
                }
            }
            $purchase->purchase_contact_call = $model->purchaseContactCall;
            $purchase->purchase_total_money = $totalMoney;
            $purchase->purchase_contact_name = $model->purchaseContactName;
            $purchase->purchase_bill_code = $model->purchaseBillCode;
            $purchase->purchase_batch = $model->productBatch;
            $purchase->save();

            return $this->redirect(['site/purchase']);
        } else {
            $products = Product::find()->groupBy('product_name')->all();
            return $this->render('addPurchase', ['products' => $products, 'model' => $model]);
        }
    }

    public function actionPurchasecart() {
        $productID = $_REQUEST['product_id'];
        $channelID = $_REQUEST['channel_id'];
        $supplierID = $_REQUEST['supplier_id'];
        $product = Product::find()->where(['product_id' => $productID])->one();
        $resp['product_name'] = $product->product_name;
        $resp['product_chemical_name'] = $product->product_chemical_name;
        $manufacture_id = $product->client_manufacture_id;
        $resp['manufacture'] = Client::find()->where(['client_id' => $manufacture_id])->one()['client_name'];
        $resp['channel'] = Client::find()->where(['client_id' => $channelID])->one()['client_name'];
        $resp['supplier'] = Client::find()->where(['client_id' => $supplierID])->one()['client_name'];
        //var_dump($resp);exit();
        echo json_encode($resp);
        exit();
    }

    public function actionAdddispatch()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $model = new AddDispatchForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $order = new Order();
            $dispatch = new Purchase();
            //var_dump($model);exit();
            $order->order_status = 0;
            $order->order_total_money = 0;
            $order->order_batch = $model->productBatch;
            $order->client_id = intval($model->client);
            //$order->client_recommand_id = $model->recommandClient;
            $order->order_bill_code = $model->purchaseBillCode;
            $order->is_dispatch = 1;
            $order->save();
            $totalMoney = 0;

            $dispatch->purchase_status = 0;
            $dispatch->purchase_total_money = 0;
            $dispatch->purchase_batch = $model->productBatch;
            $dispatch->purchase_bill_code = $model->purchaseBillCode;
            $dispatch->is_dispatch = 1;
            $dispatch->save();
            $len = count($model->productId);
            for ($i = 0; $i < $len; ++$i) {

                $productId = intval($model->productId[$i]);
                $productNum = intval($model->productNum[$i]);
                $productPrice = intval($model->productPrice[$i]);
                if ($productNum > 0) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->order_id;
                    $orderDetail->product_id = $productId;
                    $orderDetail->product_num = $productNum;
                    $orderDetail->product_price = $productPrice;
                    $purchaseDetail = PurchaseDetail::find()->where(['purchase_detail_id' => $productId])->one();
                    if($model->productChannelCost[$i]==null) {
                        $orderDetail->product_channel_cost = $productPrice/1.17 * 0.03;
                    } else {
                        $orderDetail->product_channel_cost = $model->productChannelCost[$i];
                    }
                    if($model->productProfit[$i]==null) {
                        $orderDetail->product_profit = (intval($orderDetail->product_price) - intval($purchaseDetail->price))/1.17 - ($productPrice/1.17 * 0.03);
                    } else {
                        $orderDetail->product_profit = $model->productProfit[$i];
                    }
                    if($model->totalAccounts[$i]==null) {
                        $orderDetail->total_accounts = $productPrice + $orderDetail->product_profit;
                    } else {
                        $orderDetail->total_accounts = $model->totalAccounts[$i];
                    }

                    $orderDetail->order_detail_total_money = $orderDetail->product_price * $productNum;
                    $orderDetail->save();
                    $purchaseDetail->product_residue_num = $purchaseDetail->product_residue_num - $productNum;
                    $purchaseDetail->save();

                    $dispatchDetail = new PurchaseDetail();
                    $dispatchDetail->purchase_id = $dispatch->purchase_id;
                    $dispatchDetail->product_num = $productNum;
                    $dispatchDetail->product_dispatch_id = $productId;
                    $dispatchDetail->is_dispatch = 1;
                    $dispatchDetail->price = $productPrice;
                    $dispatchDetail->product_residue_num = $productNum;
                    $dispatchDetail->client_supplier_id = intval($dispatchDetail->getSupplierByProduct($productId)['client_supplier_id']);
                    $dispatchDetail->client_channel_id = intval($dispatchDetail->getChannelByProduct($productId)['client_channel_id']);
                    $dispatchDetail->save();
                    //var_dump($dispatchDetail);exit();
                    $totalMoney = $totalMoney + $orderDetail->order_detail_total_money;
                }
            }
            $db = \Yii::$app->db->createCommand();
            $db->update('order', ['order_total_money'=>$totalMoney], "order_id=:order_id", [':order_id'=>$order->order_id])->execute();
            $db->update('purchase', ['purchase_total_money'=>$totalMoney], "purchase_id=:purchase_id", [':purchase_id'=>$dispatch->purchase_id])->execute();
            return $this->redirect(['site/dispatch']);
        } else {
            $userAddress = UserAddress::findOne(['user_address_id', \Yii::$app->user->identity->user_address_id]);
            $purchases = Purchase::find()->all();
            $purchaseDetails = [];
            foreach ($purchases as $purchase) {
                $purchaseDetail = PurchaseDetail::find()->where(['purchase_id' => $purchase->purchase_id])->all();
                $purchaseStruct['order'] = $purchase;
                $purchaseStruct['detail'] = $purchaseDetail;
                array_push($purchaseDetails, $purchaseStruct);
            }
            $clientDb = Client::find()->all();
            $clients = [];
            foreach ($clientDb as $client) {
                $clients['name'][$client->client_id] = $client->client_name;
                if($client->client_type != '生产厂商' && $client->client_type != '供应商') {
                    $clients['type'][$client->client_type] = $client->client_type;
                }
                $clients['recommand_type'][$client->client_type] = $client->client_type;
            }
            $provinceDb = region::find()->where(['region_parent_id'=>1])->all();
            foreach ($provinceDb as $v) {
                $province[$v['region_id']] = $v['region_name'];
            }

            return $this->render('addDispatch', ['products' => $purchaseDetails, 'model' => $model, 'clients' => $clients, 'province' => $province]);
        }
    }

    public function actionNotaccount() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $order = Order::find()->where(['is_dispatch'=>0])->all();
        return $this->render('notaccount', ['order' => $order]);
    }

    public function actionAccount() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $order_id = $_REQUEST['order_id'];
        $db = \Yii::$app->db->createCommand();
        $db->update('order', ['order_status'=>'1'], "order_id=:order_id", [':order_id'=>$order_id])->execute();
        $order = Order::find()->where(['is_dispatch'=>0])->all();
        $this->redirect('?r=site/notaccount', ['order' => $order]);
    }

    public function actionNotsettlement() {
        $order = Order::find()->where(['is_dispatch'=>0])->all();
        return $this->render('notsettlement', ['order' => $order]);
    }

    public function actionSettlement() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $order_id = $_REQUEST['order_id'];
        $db = \Yii::$app->db->createCommand();
        $db->update('order', ['order_settlement_status'=>'1'], "order_id=:order_id", [':order_id'=>$order_id])->execute();
        $order = Order::find()->where(['is_dispatch'=>0])->all();
        $this->redirect('?r=site/notsettlement', ['order' => $order]);
    }

    public function actionNotpay() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $purchase = Purchase::find()->where(['is_dispatch'=>0])->all();
        return $this->render('notpay', ['purchase' => $purchase]);
    }

    public function actionPay() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $purchase_id = $_REQUEST['purchase_id'];
        $db = \Yii::$app->db->createCommand();
        $db->update('purchase', ['purchase_status'=>'1'], "purchase_id=:purchase_id", [':purchase_id'=>$purchase_id])->execute();
        $purchase = Purchase::find()->where(['is_dispatch'=>0])->all();
        $this->redirect('?r=site/notpay', ['purchase' => $purchase]);
    }

    public function actionNotpurchasebatchandbill() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $model = new NotPurchaseBillForm();
        if ($model->load(Yii::$app->request->post())) {
            $len = count($model->purchaseId);
            for ($i = 0; $i < $len; ++$i) {
                if($model->purchaseBillCode[$i] != null) {
                    $db = \Yii::$app->db->createCommand();
                    $db->update('purchase', ['purchase_bill_code'=>$model->purchaseBillCode[$i]], "purchase_id=:purchase_id", [':purchase_id'=>$model->purchaseId[$i]])->execute();
                }
            }
            return $this->redirect(['site/notpurchasebatchandbill']);
        } else {
            $purchase = Purchase::find()->where(['is_dispatch'=>0])->all();
            return $this->render('notpurchasebatchandbill', ['purchase' => $purchase, 'model' =>$model]);
        }
    }

    public function actionNotorderbatchandbill() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $model = new NotOrderBillForm();
        if ($model->load(Yii::$app->request->post())) {
            $len = count($model->orderId);
            for ($i = 0; $i < $len; ++$i) {
                if($model->orderBillCode[$i] != null) {
                    $db = \Yii::$app->db->createCommand();
                    $db->update('order', ['order_bill_code'=>$model->orderBillCode[$i]], "order_id=:order_id", [':order_id'=>$model->orderId[$i]])->execute();
                }
            }
            return $this->redirect(['site/notorderbatchandbill']);
        } else {
            $order = Order::find()->where(['is_dispatch'=>0])->all();
            return $this->render('notorderbatchandbill', ['order' => $order, 'model'=>$model]);
        }
    }

    public function actionOrderinventory() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $purchases = Purchase::find()->where(['is_dispatch'=>0])->all();
        $purchaseDetails = [];
        foreach ($purchases as $purchase) {
            $purchaseDetail = PurchaseDetail::find()->where(['purchase_id' => $purchase->purchase_id])->all();
            $purchaseStruct['order'] = $purchase;
            $purchaseStruct['detail'] = $purchaseDetail;
            array_push($purchaseDetails, $purchaseStruct);
        }
        return $this->render('orderinventory', ['products' => $purchaseDetails]);
    }

    public function actionProductinventory() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $purchases = Purchase::find()->where(['is_dispatch'=>0])->all();
        $purchaseDetails = [];
        foreach ($purchases as $purchase) {
            $purchaseDetail = PurchaseDetail::find()->
            where(['purchase_id' => $purchase->purchase_id])->all();
            $purchaseStruct['order'] = $purchase;
            $purchaseStruct['detail'] = $purchaseDetail;
            array_push($purchaseDetails, $purchaseStruct);
        }
        return $this->render('productinventory', ['products' => $purchaseDetails]);
    }

    public function actionDispatchlist() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $dispatchs = Order::find()->where(['is_dispatch'=>'1'])->all();
        // $dispatchDetails = [];
        // foreach ($dispatchs as $dispatch) {
        //     $purchaseDetail = OrderDetail::find()->where(['order_id' => $dispatch->order_id])->all();
        //     $dispatchStruct['order'] = $dispatch;
        //     $dispatchStruct['detail'] = $purchaseDetail;
        //     array_push($dispatchDetails, $dispatchStruct);
        // }
        //var_dump($dispatchs);exit();
        return $this->render('dispatchlist', ['dispatchs' => $dispatchs]);
    }

    public function actionAbout() {
        return $this->render('about');
    }

    public function actionManageuser() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        }
        $regionProvinces = Region::getProvices();
        $datas = [];
        foreach ($regionProvinces as $key => $v) {
            $data['id'] = $key;
            $data['region_name'] = $v;
            array_push($datas, $data);
        }
        return $this->render('manageuser', ['regionProvinces' => $datas]);
    }

    public function actionUserlist() {
        $db = Yii::$app->db;
        $sql = "SELECT A.username, A.user_id, A.tel, B.user_type_name,
                C.user_address, C.region_province_id, C.region_country_id, C.region_city_id
                FROM user A, user_type B, user_address C
                WHERE A.user_type_id = B.user_type_id AND A.user_address_id = C.user_address_id";
        $results = $db->createCommand($sql)->query();
        $data = [];
        foreach ($results as $key => $value) {
            $b['user_type'] = $value['user_type_name'];
            $province = $value['region_province_id'];
            $city = $value['region_city_id'];
            $country = $value['region_country_id'];
            $province_name = Region::find()->where(['region_id' => $province])->one()['region_name'];
            $city_name = Region::find()->where(['region_id' => $city])->one()['region_name'];
            $country_name = Region::find()->where(['region_id' => $country])->one()['region_name'];
            $b['address'] = $province_name . $city_name . $country_name . $value['user_address'];
            $b['username'] = $value['username'];
            $b['tel'] = $value['tel'];
            $b['id'] = $value['user_id'];
            array_push($data, $b);
        }
        $a['data'] = $data;
        echo json_encode($a);
    }

    public function actionUseradd() {
        if(Yii::$app->request->post()) {
            $user_address = new UserAddress();
            $user_address->region_province_id = $_POST['regionProvince'];
            $user_address->region_city_id = $_POST['regionCity'];
            $user_address->region_country_id = $_POST['regionCountry'];
            $user_address->user_address = $_POST['detailAddress'];
            $user_address->save();

            $user = new User();
            $user->username = $_POST['username'];
            $user->password = md5($_POST['password']);
            $user->tel = $_POST['tel'];
            $user->user_type_id = 1;
            $user->user_address_id = $user_address->user_address_id;
            $user->save();
            echo json_encode('success');
        }
    }

    public function actionUserdel() {
        if(Yii::$app->request->post()) {
            $id = $_POST['id'];
            $address_id = User::find()->where(["user_id"=>$id])->one()['user_address_id'];
            $count['user']=User::deleteAll(['user_id' => $id]);
            $count['userAddress']=UserAddress::deleteAll(['user_address_id' => $address_id]);
            echo json_encode($count);
        }
    }

    public function actionUsereditlist() {
        if(Yii::$app->request->post()) {
            $id = $_POST['id'];
            $db = Yii::$app->db;
            $sql = "SELECT A.username, A.user_id, A.tel, B.user_type_name, C.user_address,
                    C.region_province_id, C.region_country_id, C.region_city_id, C.user_address
                    FROM user A, user_type B, user_address C
                    WHERE A.user_type_id = B.user_type_id AND A.user_address_id = C.user_address_id
                    AND A.user_id = $id";
            $results = $db->createCommand($sql)->query();
            foreach ($results as $key => $value) {
                $b['user_type'] = $value['user_type_name'];
                $b['region_province_id'] = $value['region_province_id'];
                $b['region_city_id'] = $value['region_city_id'];
                $b['region_country_id'] = $value['region_country_id'];
                $b['user_address'] = $value['user_address'];
                $b['username'] = $value['username'];
                $b['tel'] = $value['tel'];
                $b['id'] = $value['user_id'];
            }
            echo json_encode($b);
        }
    }

    public function actionUseredit() {
        if(Yii::$app->request->post()) {
            $user = new User();
            $u['username'] = $_POST['username'];
            $u['password'] = md5($_POST['password']);
            $u['tel'] = $_POST['tel'];
            $user->updateAll($u , ['user_id' => intval($_POST['id'])]);

            $address_id = $user->find()->where(['user_id'=>$_POST['id']])->one()['user_address_id'];
            $user_address = new UserAddress();
            $u_a['region_province_id'] = $_POST['regionProvince'];
            $u_a['region_city_id'] = $_POST['regionCity'];
            $u_a['region_country_id'] = $_POST['regionCountry'];
            $u_a['user_address'] = $_POST['detailAddress'];
            $user_address->updateAll($u_a , ['user_address_id' => $address_id]);
            echo json_encode('success');
        }
    }
}
