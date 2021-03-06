<?php
function showBravi () {
	$form_show = '
	<div class="container h-100 w-100 ">
		<div class="w-100 mt-4 mb-4 p-4 bg-secondary text-white rounded">

		<h1>Електронни брави за контролиран достъп до всички помещения и сгради</h1><br>
		<p class="text-justify">
		Електронните брави са пълноценни заключващи устройства, тялото на които съдържа всички механични и електронни компоненти, 
			необходими за тяхната работа. 
			Те могат да работят както самостоятелно, така и да бъдат управлявани от сървър или диспечерска система. 
			Може да бъде изградена цяла система от четец на данни, изпълнителен механизъм, комуникационен модул и сървър. 
			Като четец на данни, може да бъде четец на карта, чип, смарт гривна, смарт часовник, телефон или всякакво друго електронно устройство.
			Също така може да се прочитат биометрични данни, камера за лицево разпознаване или четец на пръстови отпечатъци. 
		</p>
		<p class="text-justify">
		Заключващият механизъм може да бъде няколко вида. Първият модел е : <b>Електрически насрещник</b> </p>
			<img src="img/bravi2/nasreshtnik01.jpg" height=300px>
			<img src="img/bravi2/nasreshtnik02.jpg" height=300px><br><br>
		<p class="text-justify">
		Този модел обикновенно се използва за контролиран достъп до не особено важни помещения или където може да се направи компромис със сигурността. 
		Примерно може да бъде входна врата на жилищен блок.</p>
		<p class="text-justify">
		Следващият вариант на заключващ механизъм е <b>Магнитна брава</b>. Тук важен параметър е задържащата сила. Колкото е по-силен магнита, толкова 
		е по-голяма задържащата сила и по този начин е и по-сигурно заключването.
		</p>
			<img src="img/bravi2/magnitno_zakluchvane.png" height=300px>
			<img src="img/bravi2/magnitno_zakluchvane2.png" height=300px><br><br>
		<p class="text-justify">
		Този модел е малко по-скъп от предишния, но за сметка на това е по-сигурен. Може да се ползва за заключване на входни врати на жилищни блокове, 
		офиси, мазета, тавани, гаражи и други. 
		</p>		
			

		<p class="text-justify">
		Последният вариант, който ще разгледаме е <b>Дроп-болт</b>.
		</p>		
			<img src="img/bravi2/drop_bolt_1.jpg" height=300px>
			<img src="img/bravi2/drop_bolt_na_vrata1.jpg" height=300px><br><br>		
		<p class="text-justify">
		Това е най-сигурния начин от досега разгледаните. Може да се използва за жилищни сгради, офиси, банки, преприятия.
		</p>		
		<p class="text-justify">
		И трите варианта за заключване, може да се използват с всички варианти за управление. Разликата е единствено в сигурността, която предоставят. 
		За да се повиши сигурността е желателно да се монтира и непрекъсваемо токозахранване, за да може да се осигури непрекъсваема и надежна работа.
		</p>		
		<p class="text-justify">
		Съществуват много други разновидности на заключващи системи. 
		Има варианти, в които електронно се блокира движение на обикновенния ключ или движение на дръжката на вратата. 
		Но тези модели постепенно се изместват от новите изцяло електрически модели.
		</p>		
		<img  src="img/bravi2/BravaSKod.jpg" height=300px><br><br>
	';

	$form_show .= '
	</div></div>';

	return $form_show;
}
?>