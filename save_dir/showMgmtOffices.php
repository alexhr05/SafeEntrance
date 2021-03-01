<?php
function showMgmtOffices () {
	$form_show = '
	<div class="container h-100 w-100 ">
		<div class="w-100 mt-4  mb-4  p-4 bg-secondary text-white rounded">

		<h1>Управление на офиси</h1>
		<h3>Контрол на достъпа в Офис сграда</h3><br>
			<img src="img/bravi2/office1.jpg" height=300px>
			<img src="img/bravi2/office2.jpg" height=300px><br><br>
		<p class="text-justify">
			Електронните брави отдавна са неразделна част от повечето съвременни сгради. 
			Такава популярност и широко разпространение се дължат на високата надеждност на 
			тези устройства и възможностите им за автоматизирано управление, автоматично заключване, отключване по разнообразни начини.
		</p>
		<p class="text-justify">
			Освен стандартното контролиране на работно време, тези системи позволяват да се усъвършенства и улесни работния процес в офиса. 
			Когато в една офис сграда има няколко фирми, всеки служител, ще има достъп само до помещения на неговата фирма. 
			Помощният персонал ще има достъп до тези помещения, които пряко засягат дейностите по неговите задължения.
		</p>

		<p class="text-justify">
			Ако една голяма фирма се помещава в цяла сграда, служителите от различни отдели няма да имат свободен достъп до всички помещения и пространства в сградата. 
			Достъп до счетоводство и други по-важни помещения ще имат малък кръг от служители. 
		</p>

			<img src="img/bravi2/office3.jpg" height=300px><br><br>
		<p class="text-justify">
			Четците мога да бъдат много разнообразни. От обикновенни карти/чипове, до камери, биометрични станции, лицево разпознаване, 
			пръстов отпечатък, разпонаване на глас и много други. 
			Достъпът до една офис сграда, 
			може да става от камери за лицево разпознаване, независимо дали на входа е служител или посетител. 
			Такъв тип система, може само с камери да следи кой служител в коя част на сградата се намира, без да има нужда да се чекира на всяка врата. 
			Единствено при правилно разполагане на камери и програмирането на системата ще е достатъчно, за такъв вид контрол.
		</p>

		<p class="text-justify">
			Ако настъпи аварийна ситуация като пожар или друго събитие, по електронен път се отварят определени аварийни врати, както и всички предварително 
			задаени вътрешни врати. Всичко това става автоматично, без намесата на оператор.
		</p>



		<img src="img/bravi2/parking1.png" height=300px><br><br>
		<p class="text-justify">
			Паркингът е основна част за всяка офис сграда. Поради ограничените места за автомобили е много лесно и удобно входа/изхода на паркинга да се 
			управляват централизирано. От разрешението кои служители да имат право да паркират, кои дни, на какви точно паркоместа, до преброяване на 
			заъплнени и свободни места, както и регулирането на външни посетители. 
		</p>

		<img src="img/bravi2/parking2.jpg" height=300px><br><br>
		<p class="text-justify">
			Много сгради разполагат с автоматизирано управление на вход/изход от паркинги, като дори се използват камери за разчитане на номера на 
			автомобили. Заплащане на престой над определени часове се извършва на автоматични станции без присъствието на служител. 
			Контролът на достъп за служители може да бъде, както по номер на автобил, така и с дистанционно четящи устройства, за които не е нужно 
			отварянето на прозорец, докосването на четец или друго действие. При преминаване на автомобила, системата сама прочита информацията и решава 
			дали да допусне автомобила/служителя или не.
		</p><br>
';

	$form_show .= "</div></div>";
	return $form_show;
}
?>