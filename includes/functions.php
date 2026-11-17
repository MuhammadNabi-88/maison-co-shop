<?php
function e($s):string{return htmlspecialchars((string)$s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function money($n):string{return number_format((float)$n,2,',','.').' €';}
function url($p=''):string{return BASE_URL.'/'.ltrim($p,'/');}
function go($p):never{header('Location: '.url($p));exit;}
function token():string{if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function csrf():string{return '<input type="hidden" name="csrf" value="'.e(token()).'">';}
function check_csrf():void{if(!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('Session expired. Please try again.');}}
function user(){return $_SESSION['user']??null;}
function login_required():void{if(!user())go('login.php');}
function admin_required():void{login_required();if((user()['role']??'')!=='admin'){http_response_code(403);exit('Forbidden');}}
function count_cart():int{return array_sum(array_map('intval',$_SESSION['cart']??[]));}
function items(PDO $pdo):array{$cart=$_SESSION['cart']??[];if(!$cart)return [];$ids=array_map('intval',array_keys($cart));$q=$pdo->prepare('SELECT * FROM products WHERE id IN ('.implode(',',array_fill(0,count($ids),'?')).') AND is_active=1');$q->execute($ids);$out=[];foreach($q as $p){$p['quantity']=min((int)$p['stock'],max(1,(int)$cart[$p['id']]));$p['line_total']=$p['quantity']*$p['price'];$out[]=$p;}return $out;}
function total_items($a):float{return array_sum(array_column($a,'line_total'));}
function notice($s,$type='success'):void{$_SESSION['notice']=[$s,$type];}
function image_url($s):string{return $s?:'https://images.unsplash.com/photo-1490312278390-ab64016e0aa9?auto=format&fit=crop&w=900&q=85';}
