
const myApi = api;

function tabLibrary(evt, menuName) {
	var i, tabContent, tablinks;

	if (menuName == 'generate-image' || menuName == 'search-image') {
		let footer_md = document.querySelector('.up_ft_modal');
		footer_md.classList.add('hidden');
	} else {
		let footer_md = document.querySelector('.up_ft_modal');
		footer_md.classList.remove('hidden');
	}

	tabContent = document.getElementsByClassName('tabContent');
	for (i = 0; i < tabContent.length; i++) {
		tabContent[i].style.display = "none";
	}

	tablinks = document.getElementsByClassName('menuElement');

	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" bg-gray-50", " bg-white");
	}

	const PanelArea = document.getElementById(menuName);
	PanelArea.style.display = 'block';

	evt.currentTarget.className = evt.currentTarget.className.replace(" bg-white", " bg-gray-50");

}

const BtnLibrary = document.getElementById('BtnLibrary');
BtnLibrary.addEventListener('click', async function (event) {

	tabLibrary(event, 'library');

	const library = document.getElementById('library-Contet');
	let LibLeght = library.getElementsByClassName('attachmentItem').length;

	if (LibLeght <= 0) {
		await fillAttModal();
		loadMore(1);
	}

});

async function loadMore(page) {
	const area = document.getElementById('load-more');
	let BtnLoadMore = area.querySelector('#more-btn');
	const library = document.getElementById('library-Contet');
	let LibLeght = library.getElementsByClassName('attachmentItem').length;

	if (LibLeght > 0) {
		area.style.display = 'flex';
		BtnLoadMore.ariaLevel = page;
	} else {
		area.style.display = 'none';
	}

}

const BtnMore = document.getElementById('more-btn');
BtnMore.addEventListener('click', async function () {
	buttonload('#more-btn');
	let level = parseInt(BtnMore.ariaLevel);

	let load = await fillAttModal(level);

	if (load == true) {
		let next = level + 1;
		loadMore(next);
	} else {
		document.getElementById('load-more').remove();
	}
	buttonload('#more-btn', 1, BtnMore.ariaLabel);

});


async function uploadAttachment() {
	document.getElementById('startupload').click();
}

const frmAttachment = document.getElementById('FrmAttachment');


frmAttachment.addEventListener('submit', async function (event) {
	event.preventDefault();
	animeUpload(0);
	let form = new FormData(this);
	form.append('action', 'post-attachment');
	try {
		const data = await conectApi(form);
		const response = await data.json();

		if (response['success']) {
			const fileInput = document.getElementById('file_upload');
			fileInput.value = null;
			let links = JSON.parse(response['data']);


			let i;

			for (i = 0; i < links.length; i++) {


				let preview = await createPreview(links[i]['url'], links[i]['type'], links[i]['title'])
				const previewarea = document.getElementById('new-files');
				previewarea.innerHTML += preview;


			}
			animeUpload(1);
		} else {
			animeUpload(2);
		}
	} catch (error) {
		kkMessgae.error(`Error to upload file: ${error}`);
		animeUpload(2);
	}


});

async function createPreview(url, type, title) {
	let image;
	switch (type) {
		case 'image':
			if (url != null && url != '') {
				image = '<img src="' + url + '" class="w-25 h-25 object-cover" alt="preview picture">';
			} else {
				image = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAYAAAA5ZDbSAAAAAXNSR0IArs4c6QAABJBJREFUeF7tnQGOEzEMRd2TACfZ3ZvASRZOApwEOAlwEpClLBq6045j/4wc50equlITx/mvsSedSfYiLKUVuJQeHQcnBFz8S0DABFxcgeLD4wwm4OIKFB8eZzABF1eg+PA4gwm4uALFh8cZTMDFFSg+PM5gAi6uQPHhjZrBjyKir4f2XlxG9/B+ich3Efnd3vVvaEEDfisinwnVzUiBP4mIvkMKEvBHEXmGeLW2EYX7VURUz3BBASbcMIpXBj4hICMAa1j+iR/f8hZ1Jn9oudktBgLwN+Zct/5HDRXyu6NK9z6PAn7fLqoiPrDtfQX0ost9dR0FzNw7/usZysVRwLok0lnMMk4Bnb06i10lClgvrvQii2WcAqE8HAX8xziuaD/GbqarNly/qPDDHZwOWZ/Dw/Uj4D4g6NoEjFY0mT0CTgYE7Q4BoxVNZo+AkwFBu0PAaEWT2SPgZEDQ7hAwWtFk9gg4GRC0OwSMVjSZPQJOBgTtDgGjFU1mj4CTAUG7Q8BoRZPZI+BkQNDuEDBa0WT2CDgZELQ7BIxWNJk9Ak4GBO0OAaMVTWaPgJMBQbtDwGhFk9kj4GRA0O4QMFrRHXu69UZ3Z0A2XHf6S8CdgvVW3+5t1m2asKMTjI4QsFEob7Xt3mbd5KUbrs+ETMBecoZ2ezsjQ1s1DX1eVyFgh2iWJvc2rp8ZqgnYQquzztGZIvCjjO74R8Cd8CzVLWeKnBWqCdhCrKNOz4kEZ0Am4A54R1U9B8aMzscEfETN+PlR3r1lZvTSiYCNAI+qWfLuLRsjQzUBH5EzfN6Td2+ZGxWqCdgA8F4VT97dszdq6UTAAcDevHtmqCbgAOBI3j0LMgHvKG25vYfIu2fkYwK+Unkbdm9d3aLy7hlLJwK+Uvk67F5DRufd0aGagDcK3wq7W8gj8u7IUE3ATd2jsKuQ35x88i1i6UTA7XmprP8yIPorFwGLyJlh17Mqi0BeHvDI5Y4HJjofLw34KO8iAUVtee86LQv4rOVOFOy2vSdULws4e95FheolAc+SdxF3nZYDPFPeRfzKtRTgGfNuFPJSgGfNu5F8vAzgmfNu5K7TEoAr5F1vqC4PuFLe9YTq8oCr5d3epVNpwBXzbm+oLg0Y+TPhrLYIeFZyRr8J2CjUrNUIeFZyRr8J2CjUrNUIeFZyRr8J2CjUrNUIeFZyRr8J2CjUrNUIeFZyRr/TA9YH0vWGActYBS5e8+6GrcMVbhZ4tUW1+9LO0HTZiwLWI3ifXT2zkVUBz+O4/2xHAT+2rSVWZ1mvXwE9AVdnsatEAWv+1dt+CpoFr4DumHiKmI0C1r5XeCojonGkrcJVyO6CAKydV36uyi1usGEo9770jQKss1gh84IrSLU1h8BVWyjAL8NiTo4BRpwa8J8HaMAvOVlB6+uhXYDxx5B98ApUXz9arg3l270uRgCOfYfZGqoAAUPlzGeMgPMxgXpEwFA58xkj4HxMoB4RMFTOfMYIOB8TqEcEDJUznzECzscE6hEBQ+XMZ4yA8zGBekTAUDnzGSPgfEygHhEwVM58xgg4HxOoR38BpHQUiNFZxCoAAAAASUVORK5CYII=" class="w-25 object-cover h-25"/>';
			}
			break;

		case 'audio':
			image = '<img src="data:image/png;base64,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" class="w-25 object-cover h-25"/>';
			break;

		case 'video':
			image = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAYAAAA5ZDbSAAAAAXNSR0IArs4c6QAABHhJREFUeF7tnQ2O1DAMhbMnAU4CnAQ4CXASuAlwEuAkIKNWGqqZ6XPGbdq3XyTEIhwnfl+duD/bPjWatQJP1tERXAOw+UEAYACbK2AeHhkMYHMFzMMjgwFsroB5eGQwgM0VMA+PDAawuQLm4ZHBADZXwDw8MhjA5gqYh0cGA9hcAfPwyGAAmytgHh4ZDGBzBczDI4MBbK6AeXgVGfy+tfaytfaitfZm+tlctv/C+9Vaiz8/Wmvfp5/j34dojwAOqF8mqIcI5iCTCMgfJtDDp9QL+FNr7ePw2R97AgF5zuhhM+0BDFwd1+fWWug1rGUBx7L8c9hszznwq5HLdRbwN/bc9FE2dE/OAI4KOQDT8gq8nfbjfM8He2QAs/f2ix0F19f+7v09M4BZnvt1DrgBefeWAfxn99n5DBgXPqLY2r0BeD/JM1qvzSouMEkrQmZQMnhN9vv/n9H6nqd5q5T8SUbTaAAeC3h5aVhiJxkB+DGyU++M1ssBr52iSv4kIwAPBRx362LPXTaJnWQE4GGAA2wAvtYkdpIRgIcAXrvuILGTjAC8K2D1PrvETjIC8G6AM9f7JXaSEYB3AXyrmLo1uMROMgLw5oDvFVMALpF/eye3kmmtmALw9mxKRlgCVospAJfIv72TS8CZYgrA27MpGWEGnC2mAFwi//ZOAnBPMQXg7dmUjBAP38XSXNWkMyDJiNOkKialfiR2khGAS8FUOZPYSUYArmJS6kdiJxkBuBRMlTOJnWQE4CompX4kdpIRgEvBVDmT2ElGAK5iUupHYicZAbgUTJUziZ1kBOAqJqV+JHaSEYBLwVQ5k9hJRgCuYlLqR2InGQG4FEyVM4mdZATgKialfiR2khGAS8FUOZPYSUYArmJS6kdiJxkBuBRMlTOJnWQE4BIm3PAvkfG4TiKZeGTnuHwentm8Wsbbit4VvLRVWn0lI5boh+GGg0ut49msyOZ4Nrq3SewkIwD3Mviv31LrgBu/1dALWWInGQF4E8CzU351pUTe8U7uJVNP8SUlp2REBpccHWtaZ4uvNX//Ji0ZAXgXwDFIpviS2ElGAN4NcAykFl8SO8kIwLsCVosviZ1kBOAhgGNQXqNUIv0+TjLJdDmjW8WX5E8yIoNLjoCM1ssBrxVfkj/JCMDDAV8rviR2khGADwF4WXxJ7CQjAB8K8Fx8lb8QPL6X1HthvEShEzs5xSv9e66XnphJ6dTjaY74tM7uLbNE81mdfjzDPnGXAVzxbqd+ic7d8xQfxgqJ2YfzB9qw/Temmsnga+di+XCfX49TfZwy8LAX6wfpsL13nmI2g+d+2ZvTuiQ+lsPh9izRl/Jnbk77YFuPJE6JAm78Pbz1ZvASdMB+PV0IeY4XQ+Ljk7+nD0EP+crorSOpAvDwo5QJ3FYAwOZHB4ABbK6AeXhkMIDNFTAPjwwGsLkC5uGRwQA2V8A8PDIYwOYKmIdHBgPYXAHz8MhgAJsrYB4eGQxgcwXMwyODAWyugHl4ZDCAzRUwD48MBrC5AubhkcHmgP8CZfCGeZ98+3UAAAAASUVORK5CYII=" class="w-25 object-cover h-25"/>';
			break;
		default:
			image = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAYAAAA5ZDbSAAAAAXNSR0IArs4c6QAAA9ZJREFUeF7t3WFu00AUxPHXm8BJWm5STtJyknITykngJqAnJVI/NKlrvzezu/lbiipUsuOdn7c2KYnvgm3pBu6Wnh2TC4AXPwgABnjxBhafHisY4MUbWHx6rGCAF29g8emxggEua+AhIvJxf/paNnDBQH8jIh8/IuK1YLxhhlCs4C8R8TIg6iWERH4eRujgjnQDZ1FPB/fR8fRlkDuBZ8U9H1BLIHcB54/lP46lV5w5PXIX8K+JzrkfHRNTI3cAP54uqj4qbqbvT4vcATz7uXepq+sO4PwnUa7iFbfpVnIHcF5c5UXWqttUyB3A/zbKdmRvid66f9fGmga5o+StBXZkq4AzZwrkjpJvBXgKZIC3rPnrf2folQzwceChVzLANcDDIgNcBzwkMsCXgfPcuudXnUOdkwG+DJzd7H3ZdRhkgK8D53enRgb4Y+CpkQHeBjwtMsDbgadEBvhzwNMhA/x54KmQAd4HPA0ywPuBp0AG+Bjw8MgAHwceGhngGuBhkQGu/W3S3tHaXrsGeC9J/fNakAGuhzoy4rfq9ycDfISj/rn55vNELtsALquyZKD8lIGvJSOdBrlF4NHfeVFqUjrY6aAZ/f9Fj/7W1lKT0sEmAR79zemlJqWDTQJ85EWJytPjpbFKTUoHmwg4d3XUT/8pNSkdbDJgxWp8m2G5NgFYxwywrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldFwqwrmtLEsCW2nWhAOu6tiQBbKldF7oM8Oi3rdGR7ksq/ZD20sFO8xn9tjX7atc862dEfK+M6gB+joinyp28obHKb1DZAfwQEbmK2T7fQK7eXMVlWwfwqLerKSutaaDyG1PmfnYA57ij312syejQsOW3lu0EzrEfI+Ll0JRv58nl595zdV0r+LyKE5kLrusHahtu9wo+T4tz8vvAea/g/LGcX9u2zhX8dqcT+fy4j4i80s4/39KWkPn4fbqNe15UtW8q4PaJEPB+AwAvfmQADPDiDSw+PVYwwIs3sPj0WMEAL97A4tNjBQO8eAOLT+8/2cjzedjqoX8AAAAASUVORK5CYII=" class="w-25 h-25"/>';
			break;
	}

	let htmlPreview = '<div class="checkbox-wrapper-16 attachmentItem">';
	htmlPreview += '<label class="checkbox-wrapper">';
	htmlPreview += '<input class="checkbox-input attachment" type="checkbox"  value="' + url + '">';

	htmlPreview += '<span class="checkbox-tile">';
	htmlPreview += '<span class="checkbox-icon">';
	htmlPreview += image;
	htmlPreview += '</span> <span class="checkbox-label">' + title + '</span></span></label>';
	htmlPreview += '<input type="hidden" id="type" value="' + type + '">';
	htmlPreview += '<input type="hidden" id="title" value="' + title + '">';
	htmlPreview += '</div>';
	return htmlPreview;
}


async function getAttachments(page = null) {
	let formData = new FormData();
	formData.append('action', 'get-attachment');
	if (page != null) {
		formData.append('page', page);
	}

	const data = await conectApi(formData);
	const response = await data.json();
	if (response['success']) {
		const result = await JSON.parse(response['data']);
		return result;
	} else {
		return null;
	}
}

async function fillAttModal(page = 1) {
	const list = await getAttachments(page);
	if (list != null) {
		let i = 0;

		if (list.length > 0) {
			for (i; i < list.length; i++) {
				let type = list[i]['post_att_type'].split('/');
				let url = list[i]['post_guid'];
				let title = list[i]['post_title'];
				let attachment = await createPreview(url, type[0], title);

				document.getElementById('library-Contet').innerHTML += attachment;
			}
			return true
		} else {
			return false;
		}

	} else {
		kkMessgae.error('Error when trying to get attachments');
		return false;
	}

}

const newcategory = document.getElementById('new-category');
if (newcategory != null) {
	newcategory.addEventListener('click', () => {
		const categorypanel = document.getElementById('add-category');
		let display = categorypanel.style.display == '' || categorypanel.style.display == 'none' ? 'block' : 'none';
		categorypanel.style.display = display;
	});
}


const EditVisibity = document.getElementById('edit-vibility');
EditVisibity.addEventListener('click', () => {
	const Visibilitypanel = document.getElementById('vibility-radio');
	let display = Visibilitypanel.style.display == '' || Visibilitypanel.style.display == 'none' ? 'block' : 'none';
	Visibilitypanel.style.display = display;
});

const setDatePost = document.getElementById('setDatePost');
setDatePost.addEventListener('click', () => {
	document.getElementById('postTime').innerText = document.getElementById('Datepost').value + ' ' + document.getElementById('Timepost').value;
	ShowDatePost.click();
});

const cancelSetData = document.getElementById('setDateCancel');
cancelSetData.addEventListener('click', () => {
	ShowDatePost.click();
})

const ShowDatePost = document.getElementById('show-postdate');
ShowDatePost.addEventListener('click', () => {
	const PostdateArea = document.getElementById('datapost-zone');
	let display = PostdateArea.style.display == '' || PostdateArea.style.display == 'none' ? 'block' : 'none';
	PostdateArea.style.display = display;
});


const slugedit = document.getElementById('personalized-slug');
slugedit.addEventListener('click', () => {
	const slugTextarea = document.getElementById('post_slug');
	slugTextarea.style.display = 'block';
});


const slugeauto = document.getElementById('automatic-slug');
slugeauto.addEventListener('click', () => {
	const slugTextarea = document.getElementById('post_slug');
	slugTextarea.style.display = 'none';
});


async function conectApi(data) {
	return fetch(myApi, {
		method: 'POST',
		headers: { 'Contet-Type': 'application/json' },
		mode: 'cors',
		body: data
	});
}

const BtnInsertAtt = document.getElementById('InserAttachment');

BtnInsertAtt.addEventListener('click', () => {
	switch (BtnInsertAtt.ariaValueText) {
		case 'InArticle':
			InsertAttaInArticle();
			break;
		case 'featuredImage':
			InsertFeaturedImage()
			break;
		default:
			break;
	}
})

function ModalMedia(ariaText) {
	switch (ariaText) {
		case 'InArticle':
			BtnInsertAtt.ariaValueText = 'InArticle';
			break;
		case 'featuredImage':
			BtnInsertAtt.ariaValueText = 'featuredImage';
			break;
	}

}


function InsertFeaturedImage(url = false) {
	const image = document.getElementById('post_featured');
	let attItem = document.getElementsByClassName('attachmentItem');

	if (url) {
		image.src = url;
		image.style.display = 'block';
		document.getElementById('btn-add-featured').style.display = 'none';
		document.getElementById('deleteFeatured').style.display = 'block';
		return true;
	}

	for (let i = 0; i < attItem.length; i++) {
		if (attItem[i].querySelector("input[type=checkbox]").checked == true) {
			image.src = attItem[i].querySelector("input[type=checkbox]").value;
			image.style.display = 'block';
			document.getElementById('btn-add-featured').style.display = 'none';
			document.getElementById('deleteFeatured').style.display = 'block';
			attItem[i].querySelector("input[type=checkbox]").checked = false;
		}
	}



}

const deleteFeatured = document.getElementById('deleteFeatured');

if (deleteFeatured != null) {
	deleteFeatured.addEventListener('click', () => {
		const image = document.getElementById('post_featured');
		if (image.src != '') {
			image.src = '';
			image.style.display = 'none';
			document.getElementById('btn-add-featured').style.display = 'block';
			deleteFeatured.style.display = 'none';

		}

	});
}





function InsertAttaInArticle() {
	let attItem = document.getElementsByClassName('attachmentItem');
	var i;

	for (i = 0; i < attItem.length; i++) {
		const check = attItem[i].querySelector("input[type=checkbox]");
		if (check.checked == true) {
			const title = attItem[i].querySelector('#title');
			const type = attItem[i].querySelector('#type');
			let url = check.value;
			let html;


			switch (type.value) {
				case 'image':
					post_editor.insertHTML(`<img src="${url}">`, true, true)
					break;
				case 'audio':

					html = '<audio controls><source src="' + url + '" type="audio/mp3"></audio>';
					post_editor.insertHTML(html, true, true);

					break;
				case 'video':
					html = '<video controls><source src="' + url + '" type="video/mp4"></video>';
					post_editor.insertHTML(html, true, true);
					break;
				default:
					html = '<a href="' + url + '">' + title.value + '</a>';
					post_editor.insertHTML(html, true, true);
					break;
			}

			check.checked = false;

		}
	}

}

const btnNewCategory = document.getElementById('btn-new-category');

if (btnNewCategory != null) {
	btnNewCategory.addEventListener('click', async () => {
		let txtCategory = document.getElementById('txt-new-category');

		buttonload('#btn-new-category');
		if (txtCategory.value != '' && txtCategory.value != null) {
			let form = new FormData();
			form.append('action', 'addCategory');
			form.append('name', txtCategory.value);
			const data = await conectApi(form);
			const response = await data.json();

			if (response['success']) {

				const categoryList = document.getElementById('category-zone');
				categoryList.insertAdjacentHTML('afterbegin', response['data']);

			} else {
				const allCategories = document.querySelectorAll('#post_category');

				for (var i = 0; i < allCategories.length; i++) {
					if (allCategories[i].value == response['data']) {
						allCategories[i].checked = true;
						allCategories[i].focus();
					}
				}

			}

		} else {
			kkMessgae.error('Insert category name', 5000);
			txtCategory.focus();
		}

		txtCategory.value = '';
		buttonload('#btn-new-category', 1, btnNewCategory.ariaLabel);


	});

}



const publish = document.getElementById('publish');
publish.addEventListener('click', async () => {
	buttonload('#publish', 0, '', ' Saving...');
	const postType = document.getElementById('post_type') != null ? document.getElementById('post_type').value : '';

	switch (postType) {
		case 'article':
			await postArticle();
			break;
		case 'page':
			await postPage();
			break;
		default:

			break;
	}


	buttonload('#publish', 1, publish.ariaLabel);

});


//METODO RESPONSAVEL POR POSTAR O ARTIGO
async function postArticle() {
	const data = await getPostData();
	const form = new FormData();

	const datapost = {
		'title': data['title'], 'content': data['content'],
		'featured': data['featured_img'], 'visibility': data['visibility'],
		'categoryes': data['categoryes'], 'tags': data['tags'], 'slug': data['slug'], 'post_id': data['post_id'], 'post_date': data['post_date'],
		'notify_subs':data['notify_subs']
	};


	form.append('action', 'post-article');
	form.append('postdata', JSON.stringify(datapost));

	try {
		const dataResponse = await conectApi(form);
		const response = await dataResponse.json();



		if (response['success']) {
			displayPermaLink(response['guid']);
			document.getElementById('post-id').value = response['id'];
			document.getElementById('postTime').innerText = response['date'];
			kkMessgae.success(response['message']);
		try{
			if(response.notify.success){
				setTimeout(() => {
					checkNotification(response.notify.data.id);
				}, 5000);
			}
		}catch(err){
			console.error(err);
		  }
		} else {
			kkMessgae.error(response['message']);
		}
	} catch (error) {
		console.error(error);
	}

}

async function postPage() {
	const data = await getPostData();
	const form = new FormData();
	const datapost = {
		'title': data['title'], 'content': data['content'], 'post_type': data['post_type'],
		'visibility': data['visibility'],
		'slug': data['slug'], 'post_id': data['post_id'], 'post_date': data['post_date']
	};

	form.append('action', 'post-page');
	form.append('postdata', JSON.stringify(datapost));



	try {
		const dataResponse = await conectApi(form);
		const response = await dataResponse.json();


		if (response['success']) {
			displayPermaLink(response['data']['permalink']);
			document.getElementById('post-id').value = response['data']['post_id'];
			document.getElementById('postTime').innerText = response['data']['date'];
			kkMessgae.success(response['message']);
		} else {
			kkMessgae.error(response['message']);
		}
	} catch (error) {
		kkMessgae.error('Internal error');
		console.error(error);
	}
}

function displayPermaLink(guid) {
	const permalink = document.getElementById('permalink-value');
	permalink.href = guid;
	permalink.innerText = guid;
	document.getElementById('permalink').style.display = 'block';
}
async function getPostData() {
	let dataPost = [];
	post_editor.save();
	dataPost['title'] = document.getElementById('post-title') != null && document.getElementById('post-title').value != null ? document.getElementById('post-title').value : 'Undefined';
	dataPost['content'] = post_editor.getContents();
	dataPost['post_type'] = document.getElementById('post_type') != null && document.getElementById('post_type').value != null ? document.getElementById('post_type').value : 'undefined';
	dataPost['featured_img'] = document.getElementById('post_featured') != null && document.getElementById('post_featured').src != window.location.href ? document.getElementById('post_featured').src : null;
	dataPost['categoryes'] = await getCategoryes();
	dataPost['tags'] = document.getElementById('post_tags') != null && document.getElementById('post_tags').value != null ? document.getElementById('post_tags').value : '';
	dataPost['slug'] = document.getElementById('post_slug') != null && document.getElementById('post_slug').value != null && document.getElementById('personalized-slug').checked == true ? document.getElementById('post_slug').value : null;
	dataPost['visibility'] = document.getElementById('vibility-label') != null ? document.getElementById('vibility-label').innerText : 'inherit';
	dataPost['post_id'] = document.getElementById('post-id') != null && document.getElementById('post-id').value != null ? document.getElementById('post-id').value : '';
	dataPost['post_date'] = document.getElementById('postTime') != null ? document.getElementById('postTime').innerText : '';
	dataPost['notify_subs'] = $('#notify_subs').val();
	return dataPost;

}

async function getCategoryes() {
	const categoryes = document.querySelectorAll('#post_category');
	if (categoryes != null) {
		let CategoryList = '';
		var i;
		for (i = 0; i < categoryes.length; i++) {
			if (categoryes[i].checked == true) {
				CategoryList = CategoryList + categoryes[i].value + ",";
			}
		}

		return CategoryList;
	} else {
		return null;
	}


}

function setVisibility(status) {
	const vibilityLabel = document.getElementById('vibility-label');
	vibilityLabel.innerText = status;
	EditVisibity.click();
}

function animeUpload(f) {
	const spin_area = document.getElementById('spin_load_file');
	const icon = document.querySelector('.bxs-cloud-upload');
	const colors = ['text-gray-400', 'text-green-500', 'text-purple-600'];


	switch (f) {
		case 0:
			//start upload 
			for (let i = 0; i < colors.length; i++) {
				spin_area.classList.remove(colors[i]);
			}
			spin_area.classList.add('text-purple-600');
			icon.classList.add('bx-flashing');
			break;
		case 1:
			//end upload
			for (let i = 0; i < colors.length; i++) {
				spin_area.classList.remove(colors[i]);
			}
			spin_area.classList.add('text-green-500');
			icon.classList.remove('bx-flashing');
			break;
		default:
			//no action
			for (let i = 0; i < colors.length; i++) {
				spin_area.classList.remove(colors[i]);
			}
			spin_area.classList.add('text-gray-600');
			icon.classList.remove('bx-flashing');
			break;
	}
}


