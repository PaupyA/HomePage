<?php
namespace micro\controllers\admin;
use Ajax\service\JString;
use Ajax\semantic\html\elements\HtmlHeader;
use Ajax\semantic\html\elements\HtmlButton;
use micro\orm\DAO;
use micro\orm\OrmUtils;
use micro\controllers\Startup;
use micro\controllers\Autoloader;
use micro\controllers\admin\UbiquityMyAdminData;
use controllers\ControllerBase;
use micro\utils\RequestUtils;
use Ajax\semantic\html\content\view\HtmlItem;
use micro\cache\CacheManager;
use micro\controllers\admin\popo\Route;
use micro\controllers\Router;
use micro\controllers\admin\popo\CacheFile;
use Ajax\semantic\html\collections\form\HtmlFormFields;
use micro\controllers\admin\popo\ControllerAction;
use Ajax\semantic\html\collections\form\HtmlForm;
use micro\controllers\admin\traits\ModelsConfigTrait;
use micro\utils\FsUtils;
use micro\utils\yuml\ClassToYuml;
use micro\utils\yuml\Yuml;
use micro\utils\yuml\ClassesToYuml;
use Ajax\semantic\html\elements\HtmlList;
use Ajax\semantic\html\modules\HtmlDropdown;
use Ajax\semantic\html\collections\menus\HtmlMenu;
use Ajax\JsUtils;
use Ajax\semantic\html\base\constants\Direction;
use micro\controllers\admin\traits\RestTrait;
use micro\controllers\admin\traits\CacheTrait;
use micro\controllers\admin\traits\ControllersTrait;
use micro\controllers\admin\traits\ModelsTrait;
use micro\controllers\admin\traits\RoutesTrait;
use micro\utils\StrUtils;
use micro\cache\ClassUtils;
use micro\utils\UbiquityUtils;
use micro\exceptions\RestException;

class UbiquityMyAdminBaseController extends ControllerBase{
	use ModelsTrait,ModelsConfigTrait,RestTrait,CacheTrait,ControllersTrait,RoutesTrait;
	/**
	 * @var UbiquityMyAdminData
	 */
	private $adminData;

	/**
	 * @var UbiquityMyAdminViewer
	 */
	private $adminViewer;

	/**
	 * @var UbiquityMyAdminFiles
	 */
	private $adminFiles;

	private $globalMessage;


	public function initialize(){
		parent::initialize();
		if(RequestUtils::isAjax()===false){
			$semantic=$this->jquery->semantic();
			$mainMenuElements=$this->_getAdminViewer()->getMainMenuElements();
			$elements=["UbiquityMyAdmin"];
			$dataAjax=["index"];
			foreach ($mainMenuElements as $elm=>$values){
				$elements[]=$elm;
				$dataAjax[]=$values[0];
			}
			$mn=$semantic->htmlMenu("mainMenu",$elements);
			$mn->getItem(0)->addClass("header")->addIcon("home big link");
			$mn->setPropertyValues("data-ajax", $dataAjax);
			$mn->setActiveItem(0);
			$mn->setSecondary();
			$mn->getOnClick("Admin","#main-content",["attr"=>"data-ajax"]);
			$this->jquery->compile($this->view);
			$this->loadView($this->_getAdminFiles()->getViewHeader());
		}
	}

	public function index(){
		$semantic=$this->jquery->semantic();
		$items=$semantic->htmlItems("items");

		$items->fromDatabaseObjects($this->_getAdminViewer()->getMainMenuElements(), function($e){
			$item=new HtmlItem("");
			$item->addIcon($e[1]." bordered circular")->setSize("big");
			$item->addItemHeaderContent($e[0],[],$e[2]);
			$item->setProperty("data-ajax", \strtolower($e[0]));
			return $item;
		});
		$items->addClass("divided relaxed link");
		$items->getOnClick("Admin","#main-content",["attr"=>"data-ajax"]);
		$this->jquery->compile($this->view);
		$this->loadView($this->_getAdminFiles()->getViewIndex());
	}
	public function models($hasHeader=true){
		$semantic=$this->jquery->semantic();
		$header="";
		if($hasHeader===true){
			$header=$this->getHeader("models");
			$stepper=$this->_getModelsStepper();
		}
		if($this->_isModelsCompleted() || $hasHeader!==true){
			try {
				$dbs=$this->getTableNames();
				$menu=$semantic->htmlMenu("menuDbs");
				$menu->setVertical()->setInverted();
				foreach ($dbs as $table){
					$model=$this->getModelsNS()."\\".ucfirst($table);
					$file=\str_replace("\\", DS, ROOT . DS.$model).".php";
					$find=Autoloader::tryToRequire($file);
					if ($find){
						$count=DAO::count($model);
						$item=$menu->addItem(ucfirst($table));
						$item->addLabel($count);
						$item->setProperty("data-ajax", $table);
					}
				}
				$menu->getOnClick($this->_getAdminFiles()->getAdminBaseRoute()."/showTable","#divTable",["attr"=>"data-ajax"]);
				$menu->onClick("$('.ui.label.left.pointing.teal').removeClass('left pointing teal');$(this).find('.ui.label').addClass('left pointing teal');");

			} catch (\Exception $e) {
				throw $e;
				$this->showSimpleMessage("Models cache is not created!&nbsp;", "error","warning circle",null,"errorMsg");
			}
			$this->jquery->compile($this->view);
			$this->loadView($this->_getAdminFiles()->getViewDataIndex());
		}else{
			echo $header;
			echo $stepper;
			echo "<div id='models-main'>";
			$this->_loadModelStep();
			echo "</div>";
			echo $this->jquery->compile($this->view);
		}
	}

	public function controllers(){
		$config=Startup::getConfig();
		$this->getHeader("controllers");
		$controllersNS=$config["mvcNS"]["controllers"];
		$controllersDir=ROOT . str_replace("\\", DS, $controllersNS);
		$this->showSimpleMessage("Controllers directory is <b>".FsUtils::cleanPathname($controllersDir)."</b>", "info","info circle",null,"msgControllers");
		$frm=$this->jquery->semantic()->htmlForm("frmCtrl");
		$frm->setValidationParams(["on"=>"blur","inline"=>true]);
		$input=$frm->addInput("name",null,"text","","Controller name")->addRules([["empty","Controller name must have a value"],"regExp[/^[A-Za-z]\w*$/]"])->setWidth(8);
		$input->labeledCheckbox(Direction::LEFT,"View","v","slider");
		$input->addAction("Create controller",true,"plus",true)->addClass("teal")->asSubmit();
		$frm->setSubmitParams($this->_getAdminFiles()->getAdminBaseRoute()."/createController","#main-content");
		$this->_getAdminViewer()->getControllersDataTable(ControllerAction::init());
		$this->jquery->postOnClick("._route[data-ajax]", $this->_getAdminFiles()->getAdminBaseRoute()."/routes","{filter:$(this).attr('data-ajax')}","#main-content");
		$this->jquery->execAtLast("$('#bt-controllers5CAdmin._clickFirst').click();");
		$this->addNavigationTesting();
		$this->jquery->compile($this->view);
		$this->loadView($this->_getAdminFiles()->getViewControllersIndex());
	}

	public function routes(){
		$config=Startup::getConfig();
		$this->getHeader("routes");
		$controllersNS=$config["mvcNS"]["controllers"];
		$routerCacheDir=ROOT . CacheManager::getCacheDirectory().str_replace("\\", DS, $controllersNS);
		$this->showSimpleMessage("Router cache file is <b>".FsUtils::cleanPathname($routerCacheDir)."routes.default.cache.php</b>", "info","info circle",null,"msgRoutes");
		$routes=CacheManager::getRoutes();
		$this->_getAdminViewer()->getRoutesDataTable(Route::init($routes));
		$this->jquery->getOnClick("#bt-init-cache", $this->_getAdminFiles()->getAdminBaseRoute()."/initCacheRouter","#divRoutes",["dataType"=>"html","attr"=>""]);
		$this->jquery->postOnClick("#bt-filter-routes", $this->_getAdminFiles()->getAdminBaseRoute()."/filterRoutes","{filter:$('#filter-routes').val()}","#divRoutes",["ajaxTransition"=>"random"]);
		if(isset($_POST["filter"]))
			$this->jquery->exec("$(\"tr:contains('".$_POST["filter"]."')\").addClass('warning');",true);
		$this->addNavigationTesting();
		$this->jquery->compile($this->view);
		$this->loadView($this->_getAdminFiles()->getViewRoutesIndex(),["url"=>Startup::getConfig()["siteUrl"]]);
	}

	protected function addNavigationTesting(){
		$this->jquery->postOnClick("._get", $this->_getAdminFiles()->getAdminBaseRoute()."/_runAction","{method:'get',url:$(this).attr('data-url')}","#modal",["hasLoader"=>false]);
		$this->jquery->postOnClick("._post", $this->_getAdminFiles()->getAdminBaseRoute()."/_runAction","{method:'post',url:$(this).attr('data-url')}","#modal",["hasLoader"=>false]);
		$this->jquery->postOnClick("._postWithParams", $this->_getAdminFiles()->getAdminBaseRoute()."/_runPostWithParams","{url:$(this).attr('data-url')}","#modal",["attr"=>"","hasLoader"=>false]);
	}

	public function cache(){
		$this->getHeader("cache");
		$this->showSimpleMessage(CacheManager::$cache->getCacheInfo(), "info","info circle",null,"msgCache");

		$cacheFiles=CacheManager::$cache->getCacheFiles('controllers');
		$cacheFiles=\array_merge($cacheFiles,CacheManager::$cache->getCacheFiles('models'));
		$form=$this->jquery->semantic()->htmlForm("frmCache");
		$radios=HtmlFormFields::checkeds("cacheTypes[]",["controllers"=>"Controllers","models"=>"Models","views"=>"Views","queries"=>"Queries","annotations"=>"Annotations"],"Display cache types: ",["controllers","models"]);
		$radios->postFormOnClick($this->_getAdminFiles()->getAdminBaseRoute()."/setCacheTypes","frmCache","#dtCacheFiles tbody",["jqueryDone"=>"replaceWith"]);
		$form->addField($radios)->setInline();
		$this->_getAdminViewer()->getCacheDataTable($cacheFiles);
		$this->jquery->compile($this->view);
		$this->loadView($this->_getAdminFiles()->getViewCacheIndex());
	}

	public function rest(){
		$config=Startup::getConfig();
		$this->getHeader("rest");
		$controllersNS=$config["mvcNS"]["controllers"];
		$routerCacheDir=ROOT . CacheManager::getCacheDirectory().str_replace("\\", DS, $controllersNS);
		$routerCacheFile=FsUtils::cleanPathname($routerCacheDir)."routes.rest.cache.php";
		if(\file_exists($routerCacheFile)){
			$this->showSimpleMessage("Router cache file is <b>".$routerCacheFile."</b>", "info","info circle",null,"msgRest");
		}
		$this->_refreshRest();
		$this->jquery->getOnClick("#bt-init-rest-cache", $this->_getAdminFiles()->getAdminBaseRoute()."/initRestCache","#divRest",["attr"=>"","dataType"=>"html"]);
		$this->jquery->postOn("change", "#access-token", $this->_getAdminFiles()->getAdminBaseRoute()."/_saveToken","{_token:$(this).val()}");
		$token="";
		if(isset($_SESSION["_token"])){
			$token=$_SESSION["_token"];
		}
		$this->jquery->getOnClick("#bt-new-resource", $this->_getAdminFiles()->getAdminBaseRoute()."/_frmNewResource","#div-new-resource",["attr"=>""]);
		$this->jquery->compile($this->view);
		$this->loadView($this->_getAdminFiles()->getViewRestIndex(),["token"=>$token]);
	}

	public function config($hasHeader=true){
		global $config;
		if($hasHeader===true)
			$this->getHeader("config");
		$this->_getAdminViewer()->getConfigDataElement($config);
		$this->jquery->compile($this->view);
		$this->loadView($this->_getAdminFiles()->getViewConfigIndex());
	}

	public function logs(){
		$this->getHeader("logs");
		$this->jquery->compile($this->view);

		$this->loadView($this->_getAdminFiles()->getViewLogsIndex());
	}

	protected function getHeader($key){
		$semantic=$this->jquery->semantic();
		$header=$semantic->htmlHeader("header",3);
		$e=$this->_getAdminViewer()->getMainMenuElements()[$key];
		$header->asTitle($e[0],$e[2]);
		$header->addIcon($e[1]);
		$header->setBlock()->setInverted();
		return $header;
	}

	public function _showDiagram(){
		if(RequestUtils::isPost()){
			if(isset($_POST["model"])){
				$model=$_POST["model"];
				$model=\str_replace("|", "\\", $model);
				$modal=$this->jquery->semantic()->htmlModal("diagram","Class diagram : ".$model);
				$yuml=$this->_getClassToYuml($model, $_POST);
				$menu=$this->_diagramMenu("/_updateDiagram","{model:'".$_POST["model"]."',refresh:'true'}","#diag-class");
				$modal->setContent([$menu,"<div id='diag-class' class='ui center aligned grid' style='margin:10px;'>",$this->_getYumlImage("plain", $yuml.""),"</div>"]);
				$modal->addAction("Close");
				$this->jquery->exec("$('#diagram').modal('show');",true);
				$modal->onHidden("$('#diagram').remove();");
				echo $modal;
				echo $this->jquery->compile($this->view);
			}
		}
	}

	private function _getClassToYuml($model,$post){
		if(isset($post["properties"])){
			$props=\array_flip($post["properties"]);
			$yuml=new ClassToYuml($model,
					isset($props["displayProperties"]),isset($props["displayAssociations"]),
					isset($props["displayMethods"]),isset($props["displayMethodsParams"]),
					isset($props["displayPropertiesTypes"]),isset($props["displayAssociationClassProperties"]));
			if(isset($props["displayAssociations"])){
				$yuml->init(true, true);
			}
		}else{
			$yuml=new ClassToYuml($model,!isset($_POST["refresh"]));
			$yuml->init(true, true);
		}
		return $yuml;
	}

	private function _getClassesToYuml($post){
		if(isset($post["properties"])){
			$props=\array_flip($post["properties"]);
			$yuml=new ClassesToYuml(isset($props["displayProperties"]),isset($props["displayAssociations"]),
					isset($props["displayMethods"]),isset($props["displayMethodsParams"]),
					isset($props["displayPropertiesTypes"]));
		}else{
			$yuml=new ClassesToYuml(!isset($_POST["refresh"]),!isset($_POST["refresh"]));
		}
		return $yuml;
	}

	public function _updateDiagram(){
		if(RequestUtils::isPost()){
			if(isset($_POST["model"])){
				$model=$_POST["model"];
				$model=\str_replace("|", "\\", $model);
				$type=$_POST["type"];
				$size=$_POST["size"];
				$yuml= $this->_getClassToYuml($model, $_POST);
				echo $this->_getYumlImage($type.$size, $yuml."");
				echo $this->jquery->compile($this->view);
			}
		}
	}

	/**
	 * @param string $url
	 * @param string $params
	 * @param string $responseElement
	 * @param string $type
	 * @return HtmlMenu
	 */
	private function _diagramMenu($url="/_updateDiagram",$params="{}",$responseElement="#diag-class",$type="plain",$size=";scale:100"){
		$params=JsUtils::_implodeParams(["$('#frmProperties').serialize()",$params]);
		$menu=new HtmlMenu("menu-diagram");
		$popup=$menu->addPopupAsItem("Display","Parameters");
		$list=new HtmlList("lst-checked");
		$list->addCheckedList(["displayPropertiesTypes"=>"Types"],["Properties","displayProperties"],["displayPropertiesTypes"],true,"properties[]");
		$list->addCheckedList(["displayMethodsParams"=>"Parameters"],["Methods","displayMethods"],[],true,"properties[]");
		$list->addCheckedList(["displayAssociationClassProperties"=>"Associated class members"],["Associations","displayAssociations"],["displayAssociations"],true,"properties[]");
		$btApply=new HtmlButton("bt-apply","Apply","green fluid");
		$btApply->postOnClick($this->_getAdminFiles()->getAdminBaseRoute().$url,$params,$responseElement,["ajaxTransition"=>"random","params"=>$params,"attr"=>"","jsCallback"=>"$('#Parameters').popup('hide');"]);
		$list->addItem($btApply);
		$popup->setContent($list);
		$ddScruffy=new HtmlDropdown("ddScruffy",$type,["nofunky"=>"Boring","plain"=>"Plain","scruffy"=>"Scruffy"],true);
		$ddScruffy->setValue("plain")->asSelect("type");
		$this->jquery->postOn("change","#type",$this->_getAdminFiles()->getAdminBaseRoute().$url,$params,$responseElement,["ajaxTransition"=>"random","attr"=>""]);
		$menu->addItem($ddScruffy);
		$ddSize=new HtmlDropdown("ddSize",$size,[";scale:180"=>"Huge",";scale:120"=>"Big",";scale:100"=>"Normal",";scale:80"=>"Small",";scale:60"=>"Tiny"],true);
		$ddSize->asSelect("size");
		$this->jquery->postOn("change","#size",$this->_getAdminFiles()->getAdminBaseRoute().$url,$params,$responseElement,["ajaxTransition"=>"random","attr"=>""]);
		$menu->wrap("<form id='frmProperties' name='frmProperties'>","</form>");
		$menu->addItem($ddSize);
		return $menu;
	}

	public function _showAllClassesDiagram(){
		$yumlContent=new ClassesToYuml();
		$menu=$this->_diagramMenu("/_updateAllClassesDiagram","{refresh:'true'}","#diag-class");
		$this->jquery->exec('$("#modelsMessages-success").hide()',true);
		$menu->compile($this->jquery,$this->view);
		$form=$this->jquery->semantic()->htmlForm("frm-yuml-code");
		$form->addTextarea("yuml-code", "Yuml code",$yumlContent."");
		$diagram=$this->_getYumlImage("plain", $yumlContent);
		$this->jquery->execAtLast('$("#all-classes-diagram-tab .item").tab();');
		$this->jquery->compile($this->view);
		$this->loadView($this->_getAdminFiles()->getViewClassesDagram(),["diagram"=>$diagram]);
	}

	public function _updateAllClassesDiagram(){
		if(RequestUtils::isPost()){
			$type=$_POST["type"];
			$size=$_POST["size"];
			$yumlContent=$this->_getClassesToYuml($_POST);
			$this->jquery->exec('$("#yuml-code").html("'.\htmlentities($yumlContent."").'")',true);
			echo $this->_getYumlImage($type.$size, $yumlContent);
			echo $this->jquery->compile();
		}
	}

	protected function _getYumlImage($sizeType,$yumlContent){
		return "<img src='http://yuml.me/diagram/".$sizeType."/class/".$yumlContent."'>";
	}



	public function createController($force=null){
		if(RequestUtils::isPost()){
			if(isset($_POST["name"]) && $_POST["name"]!==""){
				$config=Startup::getConfig();
				$controllersNS=$config["mvcNS"]["controllers"];
				$controllersDir=ROOT . DS . str_replace("\\", DS, $controllersNS);
				$controllerName=\ucfirst($_POST["name"]);
				$filename=$controllersDir.DS.$controllerName.".php";
				if(\file_exists($filename)===false){
					if(isset($config["mvcNS"]["controllers"]) && $config["mvcNS"]["controllers"]!=="")
						$namespace="namespace ".$config["mvcNS"]["controllers"].";";
					$msgView="";$indexContent="";
					if(isset($_POST["lbl-ck-div-name"])){
						$viewDir=ROOT.DS."views".DS.$controllerName.DS;
						FsUtils::safeMkdir($viewDir);
						$viewName=$viewDir.DS."index.html";
						$this->openReplaceWrite(ROOT.DS."micro/controllers/admin/templates/view.tpl", $viewName, ["%controllerName%"=>$controllerName]);
						$msgView="<br>The default view associated has been created in <b>".FsUtils::cleanPathname(ROOT.DS.$viewDir)."</b>";
						$indexContent="\$this->loadview(\"".$controllerName."/index.html\");";
					}
					$this->openReplaceWrite(ROOT.DS."micro/controllers/admin/templates/controller.tpl", $filename, ["%controllerName%"=>$controllerName,"%indexContent%"=>$indexContent,"%namespace%"=>$namespace]);
					$this->showSimpleMessage("The <b>".$controllerName."</b> controller has been created in <b>".FsUtils::cleanPathname($filename)."</b>.".$msgView, "success","checkmark circle",30000,"msgGlobal");
				}else{
					$this->showSimpleMessage("The file <b>".$filename."</b> already exists.<br>Can not create the <b>".$controllerName."</b> controller!", "warning","warning circle",30000,"msgGlobal");
				}
			}
		}
		$this->controllers();
	}

	public function _runPostWithParams($method="post",$type="parameter",$origine="routes"){
		if(RequestUtils::isPost()){
			$model=null;
			$actualParams=[];
			$url=$_POST["url"];
			if(isset($_POST["method"]))
				$method=$_POST["method"];
			if(isset($_POST["model"])){
				$model=$_POST["model"];
			}

			if($origine==="routes"){
				$responseElement="#modal";
				$responseURL="/_runAction";
				$jqueryDone="html";
				$toUpdate="";
			}else{
				$toUpdate=$_POST["toUpdate"];
				$responseElement="#".$toUpdate;
				$responseURL="/_saveRequestParams/".$type;
				$jqueryDone="replaceWith";
			}
			if(isset($_POST["actualParams"])){
				$actualParams=$this->_getActualParamsAsArray($_POST["actualParams"]);
			}
			$modal=$this->jquery->semantic()->htmlModal("response-with-params","Parameters for the ".\strtoupper($method).":".$url);
			$frm=$this->jquery->semantic()->htmlForm("frmParams");
			$frm->addMessage("msg", "Enter your ".$type."s.",\ucfirst($method)." ".$type."s","info circle");
			$index=0;
			foreach ($actualParams as $name=>$value){
				$this->_addNameValueParamFields($frm, $type, $name, $value, $index++);
			}
			$this->_addNameValueParamFields($frm, $type, "", "", $index++);

			$fieldsButton=$frm->addFields();
			$fieldsButton->addClass("_notToClone");
			$fieldsButton->addButton("clone", "Add ".$type,"yellow")->setTagName("div");
			if(isset($model)){
				$model=UbiquityUtils::getModelsName(Startup::getConfig(), $model);
				$modelFields=OrmUtils::getSerializableFields($model);
				if(\sizeof($modelFields)>0){
					$modelFields=\array_combine($modelFields, $modelFields);
					$ddModel=$fieldsButton->addDropdown("bt-addModel", $modelFields,"Add ".$type."s from ".$model);
					$ddModel->asButton();
					$this->jquery->click("#dropdown-bt-addModel .item","
							var text=$(this).text();
							var count=0;
							var empty=null;
							$('#frmParams input[name=\'name[]\']').each(function(){
								if($(this).val()==text) count++;
								if($(this).val()=='') empty=this;
							});
							if(count<1){
								if(empty==null){
									$('#clone').click();
									var inputs=$('.fields:not(._notToClone)').last().find('input');
									inputs.first().val($(this).text());
								}else{
									$(empty).val($(this).text());
								}
							}
							");
				}
			}
			if(isset($_COOKIE[$method]) && \sizeof($_COOKIE[$method])>0){
				$dd=$fieldsButton->addDropdownButton("btMem", "Memorized ".$type."s",$_COOKIE[$method])->getDropdown()->setPropertyValues("data-mem", \array_map("addslashes",$_COOKIE[$method]));
				$cookiesIndex=\array_keys($_COOKIE[$method]);
				$dd->each(function($i,$item) use($cookiesIndex){
					$bt=new HtmlButton("bt-".$item->getIdentifier());
					$bt->asIcon("remove")->addClass("basic _deleteParam");
					$bt->getOnClick($this->_getAdminFiles()->getAdminBaseRoute()."/_deleteCookie",null,["attr"=>"data-value"]);
					$bt->setProperty("data-value", $cookiesIndex[$i]);
					$bt->onClick("$(this).parents('.item').remove();");
					$item->addContent($bt,true);
				});
				$this->jquery->click("[data-mem]","
						var objects=JSON.parse($(this).text());
						$.each(objects, function(name, value) {
							$('#clone').click();
							var inputs=$('.fields:not(._notToClone)').last().find('input');
							inputs.first().val(name);
							inputs.last().val(value);
						});
						$('.fields:not(._notToClone)').each(function(){
							var inputs=$(this).find('input');
							if(inputs.last().val()=='' && inputs.last().val()=='')
								if($('.fields').length>2)
									$(this).remove();
						});
						");
			}
			$this->jquery->click("._deleteParameter","
								if($('.fields').length>2)
									$(this).parents('.fields').remove();
					",true,true,true);
			$this->jquery->click("#clone","
					var cp=$('.fields:not(._notToClone)').last().clone(true);
					var num = parseInt( cp.prop('id').match(/\d+/g), 10 ) +1;
					cp.find( '[id]' ).each( function() {
						var num = $(this).attr('id').replace( /\d+$/, function( strId ) { return parseInt( strId ) + 1; } );
						$(this).attr( 'id', num );
						$(this).val('');
					});
					cp.insertBefore($('#clone').closest('.fields'));");
			$frm->setValidationParams(["on"=>"blur","inline"=>true]);
			$frm->setSubmitParams($this->_getAdminFiles()->getAdminBaseRoute().$responseURL,$responseElement,["jqueryDone"=>$jqueryDone,"params"=>"{toUpdate:'".$toUpdate."',method:'".\strtoupper($method)."',url:'".$url."'}"]);
			$modal->setContent($frm);
			$modal->addAction("Validate");
			$this->jquery->click("#action-response-with-params-0","$('#frmParams').form('submit');",false,false,false);

			$modal->addAction("Close");
			$this->jquery->exec("$('.dimmer.modals.page').html('');$('#response-with-params').modal('show');",true);
			echo $modal->compile($this->jquery,$this->view);
			echo $this->jquery->compile($this->view);
		}
	}

	protected function _getActualParamsAsArray($urlEncodedParams){
		$result=[];
		$params=[];
		\parse_str(urldecode($urlEncodedParams),$params);
		if(isset($params["name"])){
			$names=$params["name"];
			$values=$params["value"];
			$count=\sizeof($names);
			for ($i=0;$i<$count;$i++){
				$name=$names[$i];
				if(StrUtils::isNotNull($name)){
					if(isset($values[$i]))
						$result[$name]=$values[$i];
				}
			}
		}
		return $result;
	}

	protected function _addNameValueParamFields($frm,$type,$name,$value,$index){
		$fields=$frm->addFields();
		$fields->addInput("name[]",\ucfirst($type)." name")->getDataField()->setIdentifier("name-".$index)->setProperty("value",$name);
		$input=$fields->addInput("value[]",\ucfirst($type)." value");
		$input->getDataField()->setIdentifier("value-".$index)->setProperty("value",$value);
		$input->addAction("",true,"remove")->addClass("icon basic _deleteParameter");
	}

	public function _deleteCookie($index,$type="post"){
		$name=$type."[".$index."]";
		if(isset($_COOKIE[$type][$index])){
			\setcookie($name,"",\time()-3600,"/","127.0.0.1");
		}
	}

	private function _setPostCookie($content,$method="post",$index=null){
		if(isset($_COOKIE[$method])){
			$cookieValues=\array_values($_COOKIE[$method]);
			if((\array_search($content, $cookieValues))===false){
				if(!isset($index))
					$index=\sizeof($_COOKIE[$method]);
				setcookie($method."[".$index."]", $content,\time()+36000,"/","127.0.0.1");
			}
		}else{
			if(!isset($index))
				$index=0;
			setcookie($method."[".$index."]", $content,\time()+36000,"/","127.0.0.1");
		}
	}

	private function _setGetCookie($index,$content){
		setcookie("get[".$index."]", $content,\time()+36000,"/","127.0.0.1");
	}

	public function _runAction($frm=null){
		if(RequestUtils::isPost()){
			$url=$_POST["url"];unset($_POST["url"]);
			$method=$_POST["method"];unset($_POST["method"]);
			$newParams=null;
			$postParams=$_POST;
			if(\sizeof($_POST)>0){
				if(\strtoupper($method)==="POST" && $frm!=="frmGetParams"){
					$postParams=[];
					$keys=$_POST["name"];
					$values=$_POST["value"];
					for($i=0;$i<\sizeof($values);$i++){
						if(JString::isNotNull($keys[$i]))
							$postParams[$keys[$i]]=$values[$i];
					}
					if(\sizeof($postParams)>0){
						$this->_setPostCookie(\json_encode($postParams));
					}
				}else{
					$newParams=$_POST;
					$this->_setGetCookie($url, \json_encode($newParams));
				}
			}
			$modal=$this->jquery->semantic()->htmlModal("response",\strtoupper($method).":".$url);
			$params=$this->getRequiredRouteParameters($url,$newParams);
			if(\sizeof($params)>0){
				$toPost=\array_merge($postParams,["method"=>$method,"url"=>$url]);
				$frm=$this->jquery->semantic()->htmlForm("frmGetParams");
				$frm->addMessage("msg", "You must complete the following parameters before continuing navigation testing","Required URL parameters","info circle");
				$paramsValues=$this->_getParametersFromCookie($url, $params);
				foreach ($paramsValues as $param=>$value){
					$frm->addInput($param,\ucfirst($param))->addRule("empty")->setValue($value);
				}
				$frm->setValidationParams(["on"=>"blur","inline"=>true]);
				$frm->setSubmitParams($this->_getAdminFiles()->getAdminBaseRoute()."/_runAction","#modal",["params"=>\json_encode($toPost)]);
				$modal->setContent($frm);
				$modal->addAction("Validate");
				$this->jquery->click("#action-response-0","$('#frmGetParams').form('submit');");
			}else{
				$this->jquery->ajax($method,$url,'#content-response.content',["params"=>\json_encode($postParams)]);
			}
			$modal->addAction("Close");
			$this->jquery->exec("$('.dimmer.modals.page').html('');$('#response').modal('show');",true);
			echo $modal;
			echo $this->jquery->compile($this->view);
		}
	}

	private function _getParametersFromCookie($url,$params){
		$result=\array_fill_keys($params, "");
		if(isset($_COOKIE["get"])){
			if(isset($_COOKIE["get"][$url])){
				$values=\json_decode($_COOKIE["get"][$url],true);
				foreach ($params as $p){
					$result[$p]=@$values[$p];
				}
			}
		}
		return $result;
	}

	private function getRequiredRouteParameters(&$url,$newParams=null){
	    $url=stripslashes($url);
	    $route=Router::getRouteInfo($url);
	    if($route===false){
			$ns=Startup::getNS();
			$u=\explode("/", $url);
			$controller=$ns.$u[0];
			if(\sizeof($u)>1)
				$action=$u[1];
			else
				$action="index";
			if(isset($newParams) && \sizeof($newParams)>0){
				$url=$u[0]."/".$action."/".\implode("/", \array_values($newParams));
				return [];
			}
		}else{
			if(isset($newParams) && \sizeof($newParams)>0){
			    $routeParameters=$route["parameters"];
			    $i=0;
			    foreach ($newParams as $v){
			        if(isset($routeParameters[$i]))
			         $result[(int)$routeParameters[$i++]]=$v;
			    }
			    ksort($result);

			    $url=vsprintf(str_replace('(.+?)', '%s', $url), $result);
				/*foreach ($newParams as $param){
					$pos = strpos($url, "(.+?)");
					if ($pos !== false) {
						$url = substr_replace($url, $param, $pos, strlen("(.+?)"));
					}
				}*/
				return [];
			}
			$controller=$route["controller"];
			$action=$route["action"];
		}
		if(\class_exists($controller)){
			if(\method_exists($controller, $action)){
				$method=new \ReflectionMethod($controller,$action);
				return \array_map(function($e){return $e->name;},\array_slice($method->getParameters(),0,$method->getNumberOfRequiredParameters()));
			}
		}
		return [];
	}

	private function openReplaceWrite($source,$destination,$keyAndValues){
		if(file_exists($source)){
			$str=file_get_contents($source);
			array_walk($keyAndValues, function(&$item){if(is_array($item)) $item=implode("\n", $item);});
			$str=str_replace(array_keys($keyAndValues), array_values($keyAndValues), $str);
			return file_put_contents($destination,$str);
		}
	}

	private function getIdentifierFunction($model){
		$pks=$this->getPks($model);
		return function($index,$instance) use ($pks){
			$values=[];
			foreach ($pks as $pk){
				$getter="get".ucfirst($pk);
				if(method_exists($instance, $getter)){
					$values[]=$instance->{$getter}();
				}
			}
			return implode("_", $values);
		};
	}

	public function showSimpleMessage($content,$type,$icon="info",$timeout=NULL,$staticName=null){
		$semantic=$this->jquery->semantic();
		if(!isset($staticName))
			$staticName="msg-".rand(0,50);
		$message=$semantic->htmlMessage($staticName,$content,$type);
		$message->setIcon($icon." circle");
		$message->setDismissable();
		if(isset($timeout))
			$message->setTimeout(3000);
		return $message;
	}

	protected function showConfMessage($content,$type,$url,$responseElement,$data,$attributes=NULL){
		$messageDlg=$this->showSimpleMessage($content, $type,"help circle");
		$btOkay=new HtmlButton("bt-okay","Confirmer","positive");
		$btOkay->addIcon("check circle");
		$btOkay->postOnClick($url,"{data:'".$data."'}",$responseElement,$attributes);
		$btCancel=new HtmlButton("bt-cancel","Annuler","negative");
		$btCancel->addIcon("remove circle outline");
		$btCancel->onClick($messageDlg->jsHide());

		$messageDlg->addContent([$btOkay,$btCancel]);
		return $messageDlg;
	}

	protected function getUbiquityMyAdminData(){
		return new UbiquityMyAdminData();
	}

	protected function getUbiquityMyAdminViewer(){
		return new UbiquityMyAdminViewer($this);
	}

	protected function getUbiquityMyAdminFiles(){
		return new UbiquityMyAdminFiles();
	}

	private function getSingleton($value,$method){
		if(!isset($value)){
			$value=$this->$method();
		}
		return $value;
	}

	/**
	 * @return UbiquityMyAdminData
	 */
	public function _getAdminData(){
		return $this->getSingleton($this->adminData, "getUbiquityMyAdminData");
	}

	/**
	 * @return UbiquityMyAdminViewer
	 */
	public function _getAdminViewer(){
		return $this->getSingleton($this->adminViewer, "getUbiquityMyAdminViewer");
	}

	/**
	 * @return UbiquityMyAdminFiles
	 */
	public function _getAdminFiles(){
		return $this->getSingleton($this->adminFiles, "getUbiquityMyAdminFiles");
	}

	protected function getTableNames(){
		return $this->_getAdminData()->getTableNames();
	}

	protected function getFieldNames($model){
		return $this->_getAdminData()->getFieldNames($model);
	}
}
