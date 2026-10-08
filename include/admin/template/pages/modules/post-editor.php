<?php
require_once('edit-post.php');
?>

<link rel="stylesheet" href="<?= URI_NAME ?>/assets/css/suneditor.min.css">
<div class="grid gap-6 px-4 py-3 mb-8 bg-white shadow-md rounded-lg  md:grid-cols-4 dark:bg-gray-800 dark:text-gray-200 ">
	<div class="w-full h-full px-5 py-4 bg-gray-100 rounded-lg  dark:bg-gray-700  md:col-span-3">
		<label class="block mt-4 text-sm">
			<input type="text" autocomplete="off" value="<?= data($data, 'title') ?>" id="post-title" name="post_title" class="<?= style['input-text'] ?>" placeholder="<?= tts['add_title'] ?>" />

		</label>
		<label class="block mt-4 text-sm <?php if (empty(data($data, 'guid'))) {
												echo 'hidden';
											} ?>" id="permalink">
			<span><?= tts['permalink'] ?>: <a href="<?= data($data, 'guid') ?>" class="text-blue-500 underline" id="permalink-value"><?php $permalink = !empty(data($data, 'guid')) ? data($data, 'guid') : 'unset';
																																		echo $permalink ?></a></span>
		</label>
		<!--Editor area -->
		<div class="w-full  mt-2 dark:bg-gray-700">
			
			<textarea id="editor" class="w-full " rows="40"><?= data($data, 'content') ?></textarea>
		</div>
		<script src="<?= URI_NAME ?>/assets/js/suneditor.min.js"></script>
		<script src="<?= URI_NAME ?>/assets/js/functions/editor.js"></script>
		<!--Editor area final-->
	</div>


	<!--Editor Lateral area-->
	<div class="w-full h-full px-2 py-2 rounded-lg bg-gray-50  dark:bg-gray-700 ">
		<!--Publish area-->
		<div class="w-full bg-gray-100 rounded-lg px-4 py-4 dark:bg-gray-800">
			<div class="mb-4 w-full rounded-lg " id="title-label"><b><?= tts['publish'] ?></b></div>

			<span class="flex text-sm gap-2 items-center">
				<i class='bx bxs-key text-sm'></i> <?= tts['state'] ?>: <span><b><?php $status = empty(data($data, 'status')) ? 'inherit' : data($data, 'status');
																					echo $status; ?></b></span>
			</span>

			<span class="flex text-sm gap-2 items-center">
				<i class='bx bx-low-vision'></i> <?= tts['visibility'] ?>: <span><b><span id='vibility-label'><?php $visibility = empty(data($data, 'visibility')) ? 'public' : data($data, 'visibility');
																												echo $visibility ?></span></b> <span class="text-blue-500 underline hover:pointer " id="edit-vibility">Edit</span> </span>
			</span>
			<span class="text-sm hidden" id="vibility-radio">
				<label class="flex gap-2 hover:pointer">
					<input type="radio" name="post_status" id="post_status_public" onclick="setVisibility('public')" <?php if (data($data, 'visibility') == 'public') {
																															echo 'checked';
																														} ?>>Public
				</label>
				<label class="flex gap-2 hover:pointer">
					<input type="radio" name="post_status" id="post_status_private" onclick="setVisibility('unlisted')" <?php if (data($data, 'visibility') == 'unlisted') {
																															echo 'checked';
																														} ?>>Unlisted
				</label>
				<label class="flex gap-2 hover:pointer">
					<input type="radio" name="post_status" id="post_status_private" onclick="setVisibility('private')" <?php if (data($data, 'visibility') == 'private') {
																															echo 'checked';
																														} ?>>Private
				</label>
			</span>

			<!--Date time-->
			<span class="flex text-sm gap-2 mt-2 items-center">
				<i class='bx bx-calendar text-sm'></i> <span><?= tts['date'] ?>: <b> <span id="postTime"><?php $date = !empty(data($data, 'data')) ? (new DateTime(data($data, 'data')))->format('Y-m-d H:i') : 'Now';
																											echo $date ?></span></b> <span class="text-blue-500 underline hover:pointer " id="show-postdate">Edit</span></span>
			</span>

			<!--Set Datetime-->
			<span class="w-full block hidden" id="datapost-zone">

				<span class="flex gap-3 flex-wrap">
					<label class="w-56">
						<input class="<?= style['input-text'] ?>" type="date" name="Datepost" id="Datepost" value="<?= date('Y-m-d') ?>">
					</label>
					<label class="w-56">
						<input class="<?= style['input-text'] ?>" type="time" name="Timepost" id="Timepost" value="<?= date('H:i:s') ?>">
					</label>
				</span>

				<span class="flex gap-3"><button class="<?= style['btn-purple-outline'] ?>" id="setDatePost">Ok</button>
					<button class="<?= style['btn-purple-outline'] ?>" id="setDateCancel"><?= tts['cancel'] ?></button></span>
			</span>

			<span class="flex text-sm gap-2 mt-2 items-center <?php $updateDate = data($data, 'data_update') != '' ? '' : 'hidden';
																echo $updateDate ?>">
				<i class='bx bx-calendar-edit text-sm'></i> <span><?= tts['update'] ?>: <b> <?= (new DateTime(data($data, 'data_update')))->format('Y-m-d') ?></b></span>
			</span>

			<?php $buttonText = !empty(data($data, 'id')) ? tts['update'] : tts['publish']; ?>
			<input type="hidden" id="post-id" value="<?php $id = !empty(data($data, 'id')) ? data($data, 'id') : 'null';
														echo $id ?>">
			<input type="hidden" name="post_type" id="post_type" value="<?= $post_type ?>">
			<button class="<?= style['btn-purple'] ?>" id="publish" aria-label="<?= $buttonText ?>"><?= $buttonText ?></button>
		</div>
		<!--Publish area-->

		<?php
		if (isset($post_type)) {
			switch ($post_type) {
				case 'article':
					include_once 'editor-parts/featured-img.php';
					include_once 'editor-parts/list-categories.php';
					include_once 'editor-parts/tags.php';
					
					break;

				case 'page':

					break;
				default:

					break;
			}
		}

		?>





		<!--Slug area-->
		<div class="w-full mt-4 bg-gray-100 rounded-lg px-4 py-4 dark:bg-gray-800 ">
			<div class="mb-4 w-full rounded-lg " id="title-label"><b>Slug</b></div>

			<div class="w-full mt-4 py-5">
				<input type="text" id="post_slug" value="<?= data($data, 'slug') ?>" name="post_slug" class="<?= style['input-text'] ?> hidden">

				<div class="w-full">
					<label class="flex gap-2">
						<input type="radio" name="permalink" id="automatic-slug" value="automatic" checked><?= tts['automatic'] ?>
					</label>
					<label class="flex gap-2">
						<input type="radio" name="permalink" id="personalized-slug" value="personalized"><?= tts['personalized'] ?>
					</label>

				</div>

			</div>
		</div>
		<!--Slug area-->


	</div>
	<!--Editor Lateral area-->



</div>
<?php include_once 'modal-files.php' ?>

<script src="<?= URI_NAME ?>/assets/js/functions/init-edite.js" defer></script>