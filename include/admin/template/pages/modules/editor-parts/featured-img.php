<!--featured area-->
<div class="w-full mt-4 bg-gray-100 rounded-lg px-4 py-4 dark:bg-gray-800">
			<div class="mb-4 w-full rounded-lg " id="title-label"><b><?=tts['featured_image']?></b></div>
			<label>
				<img src="<?php if(data($data,'featured')){echo data($data,'featured');}else{echo '';}?>" class="w-full <?php if(data($data,'featured')==null){echo 'hidden';}?> hover:pointer" id="post_featured" data-bs-toggle="modal" data-bs-target='#Modal-files' onclick="ModalMedia('featuredImage')">
			</label>
			<button id='btn-add-featured' class="<?= data($data,'featured')?'hidden':''?> <?=style['btn-purple-outline']?>" data-bs-toggle="modal" data-bs-target='#Modal-files' onclick="ModalMedia('featuredImage')"><?=tts['add_featured_image']?></button>
			<span class="text-sm text-red-600 underline hover:pointer <?php if(!data($data,'featured')){echo 'hidden';}?>" id="deleteFeatured"><?=tts['delete_featured_image']?></span>
</div>
<!--featured area-->