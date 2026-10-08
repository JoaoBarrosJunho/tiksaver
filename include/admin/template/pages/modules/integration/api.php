<div class="modal right" id="modal-docs" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="rightModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg w-100 ">
    <div class="modal-content dark:bg-gray-800 dark:text-gray-400">

      <div class="modal-header">
        <h5 class="my-4 text-xl font-semibold text-gray-700 dark:text-gray-200" id="rightModalLabel">API Docs</h5>
        <button type="button" class="text-xl dark:text-gray-100 dark:border-gray-600 dark:bg-gray-700" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-x'></i></button>
      </div>

      <div class="modal-body">
        <div class="w-full flex flex-col gap-3">
          <span class="text-lg font-semibold">API Usage</span>
          <select id="api-usage" class="<?= style['select'] ?>">
            <option value="curl">cURL</option>
            <option value="js">JavaScript</option>
            <option value="php">PHP</option>
            <option value="py">Python</option>
            <option value="node">Node.js</option>
          </select>

          <pre onclick="copyPemalink(document.querySelector('.api-usage-code').innerHTML)" class="w-full text-sm font-source-code bg-black py-4 px-4 rounded-md text-gray-400 api-usage-code " style="height: auto;white-space: break-spaces;"></pre>


          <span class="font-semibold text-lg mt-4">Request responses</span>
          <div class="w-full flex flex-col">
            <span class="font-semibold text-sm">Successful</span>
            <span class="text-sm text-gray-600 dark:text-gray-400">Status code: 200 OK</span>
            <span class="text-sm text-gray-600 dark:text-gray-400">If the video is found successfully, a JSON object with the following structure will be returned:</span>
            <div style="border-left: 1px solid #EA284E;" class="w-full  mt-4  bg-gray-100 py-4 px-4 text-gray-700 dark:bg-gray-800 dark:text-gray-400">
              <pre class="w-full overflow-x-auto">
{
  "ok": true,
  "message": "success",
  "data": {
  "url": "https://www.tiktok.com/@ahmaddar524/video/74699005606936055058?is_from_webapp=1",
  "title": "#foryoupage #zoom #virlvideo#unfrezzmyaccount ",
  "thumbnail": "https://p16-sign-sg.tiktokcdn.com/tos-alisg-p-0037/o0fnBoREallasDisRahhsjahsBI2sBK0CQgB8KtAcAA~tplv-tiktokx-cropcenter:300:400.jpeg?dr=14579&nonce=31345&refresh_token=a0ba30e24717b79b1e76cc28fac3d85f&x-expires=1741723200&x-signature=T6l4AekbsBtmRVVJrbzuyaxx44U%3D&idc=maliva&ps=13740610&s=AWEME_DETAIL&shcp=34ff8df6&shp=d05b14bd&t=4d5b0474",
  "duration": 10,
  "medias": [
      {
      "url": "https://v16m-default.akamaized.net/a5d6a0162049f1gjjgkk1b35d6ec86d8e/67cf9f56/video/tos/alisg/tos-alisg-pve-0037c001/oEeEsro2QA8EcciBtIxDfBKR9BAFPOKghSDnIC/?a=0&bti=OUBzOTg7QGo6OjZAL3AjLTAzYCMxNDNg&ch=0&cr=0&dr=0&er=0&lr=all&net=0&cd=0%7C0%7C0%7C0&cv=1&br=736&bt=368&cs=0&ds=2&ft=XE5bCqT0majPD12P~7JJ3wUOx5EcMeF~O5&mime_type=video_mp4&qs=0&rc=O2hlZjNlOThlZzU7N2U4aUBpanBzM3g5cmpkeDMzODczNEBgXy82NF9gNS0xYzJjMy1fYSNmNV4tMmRjcjFgLS1kMWBzcw%3D%3D&vvpl=1&l=202503102026186450FAA52FE4261A6247&btag=e000b0000",
      "quality": "hd",
      "extension": "mp4",
      "size": 508535,
      "size_formated": "0.48",
      "videoAvailable": true,
      "audioAvailable": true,
      "chunked": false,
      "cached": false
      },
      {
      "url": "https://v16m-default.akamaized.net/8ec1d3jakskasjc13d2df84a4c4027f9/67cf9f56/video/tos/alisg/tos-alisg-pve-0037c001/oYtoQKFcTCcBdtZRBQDAI9i8RAngXB8EvKEsfe/?a=0&bti=OUBzOTg7QGo6OjZAL3AjLTAzYCMxNDNg&ch=0&cr=0&dr=0&er=0&lr=all&net=0&cd=0%7C0%7C0%7C0&cv=1&br=794&bt=397&cs=0&ds=2&ft=XE5bCqT0majPD12P~7JJ3wUOx5EcMeF~O5&mime_type=video_mp4&qs=0&rc=OTQ3Nzk2ZjZmZDk4N2czNkBpanBzM3g5cmpkeDMzODczNEBiY140YmFjX2ExXy02MWNfYSNmNV4tMmRjcjFgLS1kMWBzcw%3D%3D&vvpl=1&l=202503102026186450FAA52FE4261A6247&btag=e000b0000",
      "quality": "watermark",
      "extension": "mp4",
      "size": 548511,
      "size_formated": "0.52",
      "videoAvailable": true,
      "audioAvailable": true,
      "chunked": false,
      "cached": false
      },
      {
      "url": "https://sf16-ies-music-sg.tiktokcdn.com/obj/tiktok-obj/7236090112017222402.mp3",
      "quality": "128kbps",
      "extension": "mp3",
      "size": null,
      "size_formated": null,
      "videoAvailable": false,
      "audioAvailable": true,
      "chunked": false,
      "cached": false
      }
  ],
  "source": "tiktok",
  "sid": "746040560693605990058",
  "author_id": "7251399390026319900",
  "author_name": "authorname"
  }
}</pre>
            </div>
          </div>
          <div class="w-full flex flex-col">
            <span class="font-semibold text-sm">Error:</span>
            <span class="text-sm text-gray-600 dark:text-gray-400">Status code: 4xx</span>
            <span class="text-sm text-gray-600 dark:text-gray-400">In case of an error, a JSON object with the following structure will be returned:</span>
            <div style="border-left: 1px solid #EA284E;" class="w-full  mt-4  bg-gray-100 py-4 px-4 text-gray-700 dark:bg-gray-800 dark:text-gray-400">
              <pre>
{
  "ok": false,
  "message": "ERROR MESSAGE"
}
</pre>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?= tts['close'] ?></button>

      </div>

    </div>
  </div>
</div>

<script>
  $("#api-usage").change(() => {
    showUsagecode($("#api-usage").val());
  });

  function showUsagecode(lang) {

    const apiDir = appApi + '/retrieve?key=YOUR_API_KEY&url=TIKTOK_VIDEO_URL';
    code = {
      curl: `
curl -X GET ${apiDir} \\
-H "Content-Type: application/json" \\
`,
      js: `const url = '${apiDir}';
fetch(url, {
  method: 'GET',
  headers: {
    'Content-Type': 'application/json'
  },
})
.then(response => response.json())
.then(data => console.log('Success:', data))
.catch(error => console.error('Error:', error));`,
      php: `<${"?"}php
$apiUrl = '${apiDir}';


$ch = curl_init($apiUrl);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_error) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);`,
      py: `import requests

url = "${apiDir}"

headers = {
    "Content-Type": "application/json"
}
response = requests.get(url, headers=headers)
print(response.json())`,
      node: `const axios = require('axios');


axios.post('${apiDir}', data, {
    headers: {
        'Content-Type': 'application/json'
    }
})
.then(response => {
    console.log(response.data);
})
.catch(error => {
    console.error(error);
});`,
    }

    code_html = code[lang] != null ? code[lang] : '';
    $(".api-usage-code").text(code_html);
  }

  window.addEventListener("load", () => {
    showUsagecode($("#api-usage").val());
  })
</script>