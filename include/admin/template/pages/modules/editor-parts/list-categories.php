<?php

use App\classes\metatags;

function CategoryLabel($id, $name, $data)
{
	$catgoryes = !empty($data) ? $data : [];

	$checked = in_array("$id", $catgoryes) ? 'checked' : '';
	echo '<label class="flex gap-2 text-sm pointer w-full py-1 hover:pointer">
				<input type="checkbox" value="' . $id . '" id="post_category" ' . $checked . ' name="post_category">	
				<span>' . $name . '</span>
				</label>';
}
?>
<div class="w-full mt-4 bg-gray-100 rounded-lg px-4 py-4 dark:bg-gray-800 ">
	<div class="mb-4 w-full rounded-lg " id="title-label"><b><?= tts['category'] ?></b></div>

	<div id="category-zone" class="w-full pl-2">
		<?php
		$categoryes = metatags::selectMetaTags('type="category"', '*', 'name ASC');

		if ($categoryes) {
			foreach ($categoryes as $cat) {
				CategoryLabel($cat->id, $cat->name, data($data, 'categoryes'));
			}
		}
		?>
	</div>

	<label class="py-4 w-full">
		<span class="text-sm text-blue-500 underline hover:pointer" id="new-category"><?= tts['add_new_category'] ?></span>
	</label>
	<div class="w-full mt-4 py-5 hidden" id="add-category">
		<input type="text" class="<?= style['input-text'] ?>" id="txt-new-category">
		<button class="<?= style['btn-purple-outline'] ?> mt-2" id="btn-new-category" aria-label="<?= tts['add_category'] ?>"><?= tts['add_category'] ?></button>
	</div>
</div>
<!--Category area-->