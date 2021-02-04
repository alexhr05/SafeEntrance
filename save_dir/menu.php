<?php
	
$menu = "";


function get_menu() {
$menu = '


<nav class="navbar navbar-expand-lg navbar-dark bg-dark pl-5 pr-5">
	<a class="navbar-brand" href="index.php?m=0"><img src="img/Logo_1_resize.png" class="rounded" width=50px height=50px></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="#">Safe Entrance</a>
        </li>
        
		
		
		
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Проекти
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="#">Управление на Къщи</a>
				<a class="dropdown-item" href="#">Управление на Сгради и Офиси</a>
				<a class="dropdown-item" href="#">Управление на Малки предприятия</a>
			</div>
		</li>
        <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Контрол на Достъпа</a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="/index.php?m=101">Електронни брави</a>
				<a class="dropdown-item" href="/index.php?m=102">Контрол и управление</a>
			</div>
        </li>
        <li class="nav-item pl-2">
            <a class="nav-link" href="/index.php?m=8">За нас</a>
        </li>
        <li class="nav-item pl-2">
            <a class="nav-link" href="/index.php?m=7">Контакти</a>
        </li>';
	if ( isset($_SESSION['auth']) && $_SESSION['auth']==true  && $_SESSION['lifetime'] > time() and $_SESSION['userType']==$GLOBALS["userTypeAdmin"] )
    $menu .= ' 
        <li class="nav-item pl-2">
            <a class="nav-link" href="/index.php?m=14">Отключване</a>
        </li>


				<li class="nav-item dropdown order-1 " id="dropdownMenu1" class="btn btn-outline-secondary dropdown-toggle">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Администраторски Панел
                        </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/index.php?m=13">Потребители</a>
                        <a class="dropdown-item" href="/index.php?m=9">Разрешени чипове</a>
                        <a class="dropdown-item" href="/index.php?m=11">Регистър на влизания</a>
                        <a class="dropdown-item" href="/index.php?m=12">Справки</a>
                        <a class="dropdown-item" href="/index.php?m=5">Изпращане на електронни съобщения</a>
                    </div>
                </li>';

	$menu .= '	</ul>';

	
	// Дали сме логнати
	if (isset($_SESSION['auth']) && $_SESSION['auth']==true  && $_SESSION['lifetime'] > time()) {
		$menu .=  '
				<font style="color:white">Здравейте, </font>';
				
							
	
    $menu .= ' 
            <ul class="navbar-nav">	
                <li class="nav-item dropdown order-1 " id="dropdownMenu1" class="btn btn-outline-secondary dropdown-toggle">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    .$_SESSION['userfulname'].'
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/index.php?m=5">Профил</a>
                        <a class="dropdown-item"  href="/index.php?m=10">Изход</a>
                    </div>
                </li>
            </ul>
              ';
			
			
				
				
				
				
				
				
				
				
    $menu .= 	'

		<ul class="navbar-nav mr-right">	
			<li class="nav-item pl-2">
				<a class="nav-link" href="/index.php?m=10">Изход</a>
			</li>
		</ul>';
				
	} else
		$menu .=  '	
		<ul class="navbar-nav mr-right">
			<li class="dropdown order-1 ">
                <button type="button" id="dropdownMenu1" data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Вход<span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right mt-2 w-75 ">
                       <li class="px-3 py-2">
                           <form class="form" role="form" method="POST" action="index.php?m=4">
                                <div class="form-group">
                                    <input id="userInput" placeholder="Електронен адрес или име" class="form-control form-control-sm" type="text" required="" name="userInput" >
                                </div>
                                <div class="form-group">
                                    <input id="passwordInput" placeholder="Парола" class="form-control form-control-sm" type="password" required="" name="pass1">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-secondary btn-block" name="send_button">Вход</button>
                                </div>
                                <div class="form-group text-center">
                                    <small><a href="index.php?m=17" style="color:white">Забравена парола</a></small>
                                </div>
                            </form>
                        </li>
                    </ul>
            </li>
		
		
		
			<li class="nav-item">
				<a class="nav-link" href="/index.php?m=65">
				Регистрация
				</a>
			</li>
		</ul>
';
	$menu .= 	'</div></nav>';

	return $menu;
}

?>