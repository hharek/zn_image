<?php
require_once("zn_image.php");

try
{
	/* Проверка является ли фаил рисунком */
	if(!ZN_Image::is_image($_FILES['image']['tmp_name']))
	{echo "Файл {$_FILES['image']['name']} не является рисунком";}
	
	/* Проверка favicon.ico */
	if(!ZN_Image::is_icon("favicon.ico"))
	{echo "Неправильная иконка";}
	
	/* Получить данные по рисунку */
	$image_settings = ZN_Image::get_settings($_FILES['image']['tmp_name']);
	$image_name = "main_image_name.".$image_settings['type'];
	
	/* Проверка по размерам */
	ZN_Image::check($_FILES['image']['tmp_name'], 800, 600);
	ZN_Image::check($_FILES['image']['tmp_name'], "<=1600", "<=1200");
	ZN_Image::check($_FILES['image']['tmp_name'], "=800");
	
	/* Конвертирование в другой формат */
	ZN_Image::convert("main.jpg", "main.png");
	
	/* Изменить размер изображения main.jpg (1600 1200) */
	ZN_Image::resize("main.jpg", 800, 400, "01_533_400.png");					// Не больше заданного размера
	ZN_Image::resize("main.jpg", 800, 400, "02_800_400.png", "<");				// Не меньше заданного размера
	ZN_Image::resize("main.jpg", 800, 400, "03_800_400.png", "=");				// Ровно заданный размер
	ZN_Image::resize("main.jpg", 2000, 1600, "04_2000_1500.png", ">", true);	// Увеличить рисунок
	
	/* Наложить водяной знак */
	ZN_Image::apply_image("main.jpg", "watermark.png", "main_s_zashitoy.jpg", 50, "right", "bottom", 20);
	
	/* Выгрузить рисунок */
	ZN_Image::output("main.jpg", 400, 300);							// Выгрузить рисунок с новым расширением
	ZN_Image::output("main.jpg", 100, 100, "new.gif", false, "<");	// <img src="/image.php" width="300" height="200" />
	
	
}
catch (Exception $e)
{
	echo $e->getMessage();
}	
?>
