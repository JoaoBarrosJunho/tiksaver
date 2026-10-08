<?php

namespace App\classes;

use App\db\database;
use DateTime;
use PDO;

class gadget
{
    private $gadget_list = [
        ['id' => 1, 'name' => "HTML/JavaScript", 'icon' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAAAXNSR0IArs4c6QAAA01JREFUaEPtmk1u2zAQhYdur1AV3TknaXwS10dIhKwbrwu3R7Bzkvgm1a6Ic4VYLKhIgUDz53FIikAiLWOKnI/km3mkIuiDPeKD8dIM/N5XfF7heYXf2QwU39JPO3kvBH0nSY1o6eHlMzXfbkSTa56LA59+y0eSdK0BbqpaHHJAlwfeSamDVbXIFle2jpHV+fdHLj+19Fdr21S1uELe57QpCtzpl+inFvihqsWGA4O8UxTYpF9JtP1ai3skeE6bssAG/YqWVl/uxJEDg7xTDNiiX8qZsNSEFAM+7eQPItpPmbCKApsSVm79FgWe2nAMOynJln7+Ja/lgvbnBa1QW3gKMBynnVR9b9G+XckrGriHfVSDoFsyxHAoWCJSeldPtOWMAubWUdRwmBKbmtR2QQfuarOAuxWStDeY/m4Zzgu6cgWETNR451xsUUHHs6ANBzoY2BnIaxo8Vrdi5dKRSb+64ei3vZLK0tJXE5IzWEkrBWyo4dA0bGIP0jW8wpYy8hYAagk5hqPX/Nq22iG69gL79ErU3VRsUP/LNRxD6bNucVDXTuAUW1jfgzGGI4WurcA5YBV8iOGwJb4YXRuBLToL1qsecIjh8B31EF2bztU24It7pj6AIL3qQaOGwwc7/O7UtaU82oDVPZOp/rFq3xAgYjhQWNXOIzvj3ZgR2LIS41iCat8bcMIbDl+Osfl6a9JCNBLiaUMNh9Opme+yoRyDlCV1WjHbO7D29dk5+oYjhSfAjEdL0Z6Wazi0BNUdQ40P4OFfrT74xNS+boUjPqn49IocWFiHhxhdcw1HKg/PAh6VgiBdcwxHCr2aNi+8pccv+zytfnLiGA7nGKBekwGP6ur4vmn480WN5hoO40RFwAYlLVtu03Rt/BCG3HB4+u8+uKFnblceZm1pvcM+i65NX/1SGA61Q8SZtuiZOzuw0xUV+qRiL9dgHeY2izUc3HGLAccYjtSwSZKWLyiu4fD1y/09SdKyDc4xHFwQ9L2swBzDgQbObZcVmGs4uDDIe3mBE95wIDBIm2zAKQwHAhDaJhsw55NKaPCc9tmAVTC95VySoDVJWkqih5z/g4VMQFZgJICp28zAU8/41OPNKzz1jE893rzCU8/41OP9B+gjSFsyuy/0AAAAAElFTkSuQmCC"],
        ['id' => 2, 'name' => "Search Box", 'icon' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAAAXNSR0IArs4c6QAAA7tJREFUaEPtmlt22jAQhkcpXUfJSoAdwAoS1hF6Qk7JOkJWADuIu5LQdTSNeiRfYuIZzUga3OOCX3jAtvTpn5tGNnBmlzkzXrgA/++KXxTOUdiud2N4g1uw5hsYGIOFcfV78O81cAALBzD2FwAUZrMocsZLeTZb4RbkjYeLuUr4ZxjB1qwX5aKc+MoCtqvdGsDcZ8+xAjebxTr7XcwLkoDtajcFMC/qk+sBPBpYTdXgatmHU6kdBWxXe6fqNDzXyi8BChjBwfmm93N3vdVBzNwI3rM1j/OlthWJgXnYOFWaYBeKARbUoUXAjBkXMLLL1CjLg8ctJGcRLHA4QOlNJrioxi7Nj8WWg5H8zwPf7V/x/Gpn2oWD/b5zRctTZ+IWDuZxfi0B4u4JAtOrHlb2w0x9eTXxFZcLYlf2p6u0QgtFjqnkzwzw3iIrVpjNfIatZAnqFeIj+Vc7o/ze3u2fwMDt0RguRwee4ZSt/yeB0UHdUyN7jU00Oj8Hioxq4V67EPkxIwTc9d2AWUUDNzQ4BPo+BV+mgVeIORPq1nNPgi6VXn7264DKWcESBUajpTBoNNAO5Mo+wBcot4B/YAqWqLAI5fBiJ8+scWAsaETkQrdgWN4MFxndNEdYDBk0JYELB0ZrZp28S0fyrnJE0XMCYKzYYPxXsrotX8e2lx0Q1I8zAxelcCf/ms2crcqk0FIQ6X3ScX0ZhBYQSITWBI6ZoFWeCxW0ujlY0aSlwH0qjGz0dYKWFNbd12fQ6taykJf/YkCb4IbtnoT1ADWevPDwfWR805ACI3kGLTwi6gFsDBy43PV0ive+AxcWsKjNi2QByShd+g/SsMs0J+mk/PhYtefSSmZ6DGwekCa70p6UAyc3DpnmHFaYMGvoQWWqQ5qrbhDYmxXVYzphxP63LR6n8m/zQjTx1E8HyA5pZv3cdiG2PqZV9jagBh1uHugVPSxwVfGETgkVGvGBxp9yoBQBs9AJp378iUPLEBWh5cD16T53HlwfclOHab6FayZsK/dz7lKCFgO3Nu86h+BcMkb3rfm96WjgJl29m/voTxw4yKqD6Y5ZyeyQqXQSsIeWmjgH2fx/HPH9+6mUmAGdDNyY+Ad4ml8a+0yd9p8COhu4LaCfoOs/v5vJ0WdL3iSg/kqn8J8tCb/c0YZWBRZbb+SNmtCDAG5ihoJPDwZYC3pQwCy0oLYfHDAJLdynDxK4Ay2EZRsAkcG099vr4ifmq73BKpy6uhfg1JUbynMXhYeiVOo8LwqnrtxQnjs7hf8CoUaNW28MP2EAAAAASUVORK5CYII="],
        ['id' => 3, 'name' => "Popular Posts", 'icon' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAAAXNSR0IArs4c6QAAA15JREFUaEPtmuttGzEMxyn4AXQLZ4+6lSepPUmSSeJOEqHuHvEWAfyICjl3hizoRFLiyYfm/DHRSfqR4p/UQ8EX+6kvxgsj8P/u8dHDo4czLPCu9WJyBn2egPlmzD6ji94+6WVJH5fauhlbgL1S8Hv2xzz1RsDsWBz4+F1rUPDqz+MCbmEz+2sMc37izcWBD0u9VgAv4UyH4u1qwK0BLMB2vjMbcdcRO+wD+EUBrFPjO2+fJ7C6h6D1AfymABaYwR30fGcesHbS/xcFjgkW5una0LLAS+3UWXO8UjumxYC53r0xioVVrZQlB5zhXU+5q8WzCPCxANaD3sx3ZssJh5y2xcDHH/oJLDzmDB5WYykBcyFzmsK+NJUVARfFbWChVJpqjSpRomYDux3R9AxvpZ6liJcfMqX5Owu42f69UgoMjkEsQDSOD0t9U8yUpLIsYAmRihpCwXNsK9luN31Vz919sYF7g3U0EeBE6JjZzqw4K+hzCMava+vH6CLdNAKcHDOjYGEBh0tLDLTpKBbDYfwGqYy91SQDH5Ya3faVGuA0gQc/z2IrKidNkYAl823KKLOduc6Hmva6lL1rHBJwDe/6qYYK20CxxIsE3Hfsuom3nuKWqtxCBAXG4qg0br3cusWOhjrHYqg1Ctxr3pWyVkfBEuueAnw5VB/yj1NqJoGZ4nFPm5CFKwnMjl8Fz2DhJ/dcS8BS9YFbtayRwkIDcZQ66WFOirimlcjdkoAH0S78oiXVWGxJtwPeK+5FgKklZaiSNQqVYBNBPvWUUekgD94hjmVEy1kxtT3zqqSbo5nay1osDzsgSqUV27FQvkOViNiAs2PCKy2C6kaBCd8RedBm4T46W6XbD1FvdR++sS/XULpIA6pCu09RDzdxHH3G4I0dFY0ascyJXzJwM3H3biN6FZqqdNjlKdPFnOVMBnYNMW+lhINTsXF4ud5lAWNLG6tnpaGx8boMR4ph/+PUxLH0IArNOOXw588GvuTmjitSyuuc0nupnKPZYuBrTH/AOrwbpiy1ix5EviXEL7mEFFvSYUft5K2FX+1tIlVMPPDkoUGpV0U8HAN3f5ueYGEVLLgvadsXuBclVc07rw8w0o9dsmKYsPQG22QEHqxrhCY2eljIkIPtZvTwYF0jNLF/TljwTL9t8QcAAAAASUVORK5CYII="],
        ['id' => 4, 'name' => "Recents Articles", 'icon' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAAAXNSR0IArs4c6QAAAQJJREFUaEPtmTEOg0AMBE3Ji3hS8ow8gzyJF1EmRbr4kFygXck3lAjY847PrHRLTHYtk9UbFNydOIQh3MwBWroZ0FQOhCHczAFauhlQhla5pc/j8fm3a93e6f3Rc4quGa1lpEvBVzQgHBG0dES02cOKwaPQKA8txWIUGhSscNmpAWGn+wptCF8nrecrZ+k93TuP/JyC3LrltZClI+pHLWRpsvRvx7TJ0qNhNBoUbYaWYtIqNPgPK1x2akDY6b5CG8IKl50aZcJES6Jlu2jJ2VLvkwfnZL1Tuzyl7xR1fouCne4rtCGscNmpAWGn+wptCCtcdmpA2Om+QhvCCpedGtMR/gLLZ4A9V06vLwAAAABJRU5ErkJggg=="],
        ['id' => 5, 'name' => "Category List", 'icon' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAAAXNSR0IArs4c6QAAAtZJREFUaEPtWu1x2zAMBRvbd93CmaT+GCT2Btqg6QbawOkgjt1Joi16Z/eCnqjYF0kgCX6IomP6r0WBDw8AgUcJuLOfuDO8kAF/dcYzw5nhL+YBY0gXh79zeJ9s/HBjVa5nL6p3xLBxsW0G/Hp6AxBzP8D1aqzK1eyRek8RwQYLcLE/bUCInT/Yjzcg/CrX0+fP74th47M9LcPF/vwMAn4OC3h4GxmwspjQDB8B4Y+RdQE/AGDReo4MaZLhoDb8GCY2TRYiyllcwIFtZMBWIR3Y+2RhDGwjM5wZ/vBAjHCLYSOHdA7pHNKtGAjaBSn69aA2/HLY2FNqHuB2WoFtZMBWRcvL+7jtKh/hR9C+DT7DtbyDD4chFQ8p7wxsgw24frDRmx4WvqC7SkdL9YhggyXx+ERvqmuNIl6qG3fdVwbs6rlbWWdkOKZITkpFdUGDyRzecQ7fRFUup0cf55oBRxTJL0CuTlZKxFgBit+6yq9yikGXHl6I726sOJwXgHDgsWgPfHQhvnUeuwr/TA2stpUMYDtmCf4FLDn57QJ4kNFNfaGGFYCoALECIS/12uL+Fbv6so7dWsbSm4r9aQdC9K9kEV/K9Wzbb0MnG/LOi3i+Gwv2DDPzxcZZJLuGzdNTlpnlRACfsctEuZrq9yanrMlbL5vFv8dy+b1yPJaIi67ADJP3w4zQlJPc67k+vto5bSheozNsE/q9M5t5YZdU0VIcR8dyNV2amg+y2KGP4uHgwWt7yFzbKB7dXDQXnyakie9PUs9h5cZNVZrKXwAwFbvRc1gCVp7D/Y9gmucV34Uwip09YIDgnZZeyBu70zJVEt3/miMt5V7aHbLhDHfWqJm9wQjTkv7IkPkp52Hc8WRhOVBsOVPShSVG+zasEK+UdervOwU+0cDtB38W4MbjwwvxuhyR9mNqWu4Jm+ZKo4iX5rbdd5UBu/vuNlZmhm+DJ/dd3h3D/wGTKAlqg4Y4KgAAAABJRU5ErkJggg=="],
        ['id' => 6, 'name' => "Social Links", 'icon' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAAAXNSR0IArs4c6QAAA4JJREFUaEPtmltuEzEUho8hvM8S2pWUqEFiFzQrKaykyS6QSNWwkmYJ806oyQk2MoMv/7E9F5qJVPUh4xl//s99oujCPurCeGkGfu2KzwrPCr+yE5hNemxBPzb6ivdwJDr/58+uVfta+5qEwgx5JLrTRJ+UA2ohNdFB/f7bfmvVpgR+VGALSkT3KISB3+5a9Rld4143GrCBfSCi9zkbJ6IvOdCjAK8azZBPmaB/lrHaj626ltxncGAE1vqsAxK0Ak20eWzVGoUeHPhDozk4sSn/9Yn5ZsrXFdEaDWaDAzNlF5ph3xEtv7bqEFMqdlioaY8C7EJL/TAEjao8GrCFRk3RVf620Q+nvHzXsYb9rlXLlC+PCpzaXOh749PP7veopfyXwAy6ajSntW70XqbK0Bk418y665xUwl/dnPLlFdfDbHpviL7z/5Qasb34/BgJXNUV5sKC86yvCfDlXiQd+cBvG/3cfcaC6DqV2qoCrxrNBT3cCDBIbjOwarTuHsRgwGy+P4ieEFVDZooWHyZg+Q52mLSE1MZoXECgfSnJ3B/qnopMOgVrzfWUPvYLosNPk0a40Y+0hUGlYi0lYs58MNnAMVjEL33+btatfdE7BivpmLKAU7BoIe/6fgGsqCcWA9eCtX7tKMc++M+wDpiMJKsrN4aIgCMB45xeQspaJaU5tzas2IcD9WsS9kh0LvSRKOxRPjTtEClr7wsrHGjJYFj7QCSghXpexzSzYGGFQ6acasl85V8XnOvrt0R7M3jnstQ7m64BCwNHSsboSdeowDpFS7ayIpMOKAVVNjWgYykLreJEwLmFeicA8UhG1FhISkYUPBm0AnkXKtR9PTLaZNRUVZSHfRFTUsr5Tp7NnOvqF6Ib7rB4OGACytZczwda7Y2hCLimwqjZ9Xld0qRLJoR9bjz33lnA5mHFKSJ30yXrksB8c19JmePH1ndzhu8lkCIf5osjpR6Ui/kethEw08vsF9ql4JDCoeIBqYtdWDvlQNeVwvnWQ8AJlbmB2PDvL7qpJPaacyxoGNj4cnQMK3mRPVbgEwEDDTlkhX1VUcjDRcCOP+bWxXbw7h3UIRsuvUYMbB/IkfuF6F44fIejeilYaH02sFWba+LYnNkGpwXRJvXepy9IcR5GNtL3TwaRPSDXFCmMPGBq18zAU1Ok9n5mhWuf6NTuNys8NUVq7+fiFP4FxVMHW1DgOcwAAAAASUVORK5CYII="]
    ];

    public function getGadget_list()
    {
        $gadget_list = $this->gadget_list;
        return $gadget_list;
    }



    private function create_element($id, $title, $icon)
    {
        $HTML = '<li class="flex gap-6 items-center justify-between py-4 px-4 bg-gray-100 dark:bg-gray-700 rounded-md">
        <label class="flex gap-6 items-center"><img src="@icon" class="w-8 h-8">@title</label>
        <label><button class="' . style['btn-purple-outline'] . '" onclick="getGadget(@id)">+</button></label>
        </li>';

        return str_replace(['@id', '@title', '@icon'], [$id, $title, $icon], $HTML);
    }

    public function getList()
    {
        $HTML = '<div class="w-full h-full bg-white text-sm text-gray-700 dark:bg-gray-800 dark:text-white">
        <ul class="flex gap-3 flex-col scroll-auto hidde-scroll">
            @list
        </ul>
        </div>';
        $list = [];
        $gadgets = $this->getGadget_list();
        foreach ($gadgets as $g) {
            $list[] = $this->create_element($g['id'], $g['name'], $g['icon']);
        }
        return  str_replace('@list', implode("\n", $list), $HTML);
    }


    public static function newGadget($data)
    {
        define('gd_data',$data);
        function getData($Name, $Array)
        {
            return isset($Array[$Name]) ? $Array[$Name] : null;
        }

        $success = false;
        $dataContent = '';
        $response = [];
        $form = '<form id="newGadgetForm" method="POST" class="flex flex-col gap-3">
                    <input type="text" name="gadget[gadget_title]" value="' . getData('gadget_title', $data) . '" 
                    placeholder="Title" class="' . style['input-text'] . '">
                    
                    @addoms
                    <button type="submit" class="hidden" id="sendGadgetform">send</button>
                    <input type="hidden" name="widget_item_id" value="' . getData('widget_item_id', $data) . '">
                    </form>';

        $option = isset($data['option']) ? $data['option'] : null;

        switch ($option) {
            case 1:
                //HTML/JS CODE
                $addoms = '<textarea name="gadget[gadget_content]" placeholder="Put HTML/JavaScript code here!"  cols="30" rows="10" class="' . style['input-text'] . '">' . getData('gadget_content', $data) . '</textarea>
                <input type="hidden" name="gadget[gadget_type]" value="' . $option . '">';
                $dataContent = str_replace(['@addoms'], ["$addoms"], $form);
                $success = true;
                break;

            case 2:
                //SEARCH BOX
                $addoms = '<input type="hidden" name="gadget[gadget_type]" value="' . $option . '">';
                $dataContent = str_replace(['@addoms'], ["$addoms"], $form);
                $success = true;

                break;

            case 3:
                //POPULAR POSTS
                $value = getData('num_articles', $data);
                $num_articles = !empty($value) && is_numeric($value) ? $value : 5;
                $addoms = '
                <label class="flex gap-3 items-center mt-4">
                <span>Number of articles:</span>
                <label class="w-25">
                <input type="number" name="gadget[num_articles]" value="' . $num_articles . '" class="' . style['input-text'] . '">
                </label>
                </label>
                <input type="hidden" name="gadget[gadget_type]" value="' . $option . '">';
                $dataContent = str_replace(['@addoms'], ["$addoms"], $form);
                $success = true;

                break;

            case 4:
                //RECENTS ARTICLES

                $value = getData('num_articles', $data);
                $num_articles = !empty($value) && is_numeric($value) ? $value : 5;

                $addoms = '
            <label class="flex gap-3 items-center mt-4">
            <span>Number of articles:</span>
            <label class="w-25">
            <input type="number" name="gadget[num_articles]" value="' . $num_articles . '" class="' . style['input-text'] . '">
            </label>
            </label>
            <input type="hidden" name="gadget[gadget_type]" value="' . $option . '">';
                $dataContent = str_replace(['@addoms'], ["$addoms"], $form);
                $success = true;
                break;

            case 5:
                //CATEGORY LIST
                $value = getData('num_articles', $data);
                $num_articles = !empty($value) && is_numeric($value) ? $value : 30;

                $addoms = '
            <label class="flex gap-3 items-center mt-4">
            <span>Number of items (0 for show all):</span>
            <label class="w-25">
            <input type="number" name="gadget[num_articles]" value="' . $num_articles . '" class="' . style['input-text'] . '">
            </label>
            </label>
            <input type="hidden" name="gadget[gadget_type]" value="' . $option . '">';
                $dataContent = str_replace(['@addoms'], ["$addoms"], $form);
                $success = true;
                break;
                case 6:
                    //SOCIAL Links
                $value = getData('num_articles', $data);
                $num_articles = !empty($value) && is_numeric($value) ? $value : 30;
                
                function inPlatform($platform){
                    $platforms = getData('platform',gd_data)??[];
                    return in_array($platform,$platforms)?'checked':'';
                }


                function getOrientation($o){
                    return getData("orientation",gd_data)==$o?'checked':'';
                }

                function getButtons($o){
                    return getData("buttons",gd_data)==$o?'checked':'';
                }
                

                $addoms = '
            <div class="flex flex-col gap-6  mt-4">
            
            <div class="flex flex-wrap gap-3">
            <span class="text-sm w-full">Platforms</span>
            <label class="flex items-center gap-3">
            <input type="checkbox" name="gadget[platform][]" value="facebook" '.inPlatform("facebook").'>
            <span class="text-xs">Facebook</span>
            </label>
            <label class="flex items-center gap-3">
            <input type="checkbox" name="gadget[platform][]" value="x" '.inPlatform("x").'>
            <span class="text-xs">X/Twitter</span>
            </label>
            <label class="flex items-center gap-3">
            <input type="checkbox" name="gadget[platform][]" value="instagram" '.inPlatform("instagram").'>
            <span class="text-xs">Instagram</span>
            </label>
            <label class="flex items-center gap-3">
            <input type="checkbox" name="gadget[platform][]" value="youtube" '.inPlatform("youtube").'>
            <span class="text-xs">Youtube</span>
            </label>
            <label class="flex items-center gap-3">
            <input type="checkbox" name="gadget[platform][]" value="linkedin" '.inPlatform("linkedin").'>
            <span class="text-xs">Linkedin</span>
            </label>
            </div>

            <span class="text-sm">Customizations</span>
            
             <div class="flex flex-wrap gap-3">
             <span class="w-full text-sm">Orientation</span>
            <label class="flex items-center gap-3">
            <input type="radio" name="gadget[orientation]" value="" '.getOrientation('').'>
            <span class="text-xs">Horizontal</span>
            </label>
            <label class="flex items-center gap-3">
            <input type="radio" name="gadget[orientation]" value="flex-col" '.getOrientation('flex-col').' >
            <span class="text-xs">Vertical</span>
            </label>
            </div>

             <div class="flex flex-wrap gap-3">
             <span class="w-full text-sm">Buttons</span>
              <label class="flex items-center gap-3">
            <input type="radio" name="gadget[buttons]" value="" '.getButtons("").'>
            <span class="text-xs">Flat</span>
            </label>
            <label class="flex items-center gap-3">
            <input type="radio" name="gadget[buttons]" value="rounded-full" '.getButtons("rounded-full").'>
            <span class="text-xs">Circle</span>
            </label>
            <label class="flex items-center gap-3">
            <input type="radio" name="gadget[buttons]" value="rounded-md" '.getButtons("rounded-md").'>
            <span class="text-xs">Rounded</span>
            </label>
            </div>

            </div>
            <input type="hidden" name="gadget[gadget_type]" value="' . $option . '">';
                $dataContent = str_replace(['@addoms'], ["$addoms"], $form);
                $success = true;
                    break;

            default:
                $success = true;
                $dataContent = (new gadget())->getList();
                break;
        }
        $response = ['success' => $success, 'data' => "$dataContent"];
        return $response;
    }


    public static function getGadgetHTML($option, $addoms = [])
    {
        $response = '';
        $image_style = isset($addoms['image_style'])?$addoms['image_style']:'w-12 h-12 rounded';
        $input_css = self::addom($addoms, 'input_class') ? self::addom($addoms, 'input_class') : style['input-text'];
        $button_css = self::addom($addoms, 'button_class') ? self::addom($addoms, 'button_class') : style['btn-purple-np'];
        $title_css = self::addom($addoms, 'title_class') ? self::addom($addoms, 'title_class') : "text-lg font-semibold uppercase";
        $op = isset($option['gadget_type']) ? $option['gadget_type'] : null;
        $title = isset($option['gadget_title']) ? $option['gadget_title']:'';
        switch ($op) {
            case 1:
                // HTML Code
                $response = isset($option['gadget_content'])?$option['gadget_content']:'';
                break;

            case 2:
                // searchbox
                $class_searchform = self::addom($addoms,'class_searchform') ? self::addom($addoms,'class_searchform'):"flex gap-3 w-full h-12 items-center";
                $html = '<form action="'.URI_NAME.'/" method = "GET" class='.$class_searchform.'>
                    <input type="search" name="s" class="'.$input_css.'" placeholder="Search here...">
                    <label class="ml-2 flex items-center"><button type="submit" class="'.$button_css.' text-lg"><i class="bx bx-search"></i></button></label>
                    </form>';

                $response = $html;

                break;

            case 3:
                // Popular posts
                
                $PopularPosts = (new database('postmetrics'))->selectINNERJOIN(null," posts ON postmetrics.post_id = posts.id AND posts.post_visibility='public' GROUP BY  post_id HAVING post_type='article'","TotalViews DESC",$option['num_articles']." OFFSET 0"," post_id,post_title,post_date,post_guid,post_type,COUNT(*) AS TotalViews ")->fetchAll(PDO::FETCH_CLASS);
                $html = '';
                if($PopularPosts){
                    
                    $html .= '<ul class="flex flex-col gap-3 ">';
                    foreach($PopularPosts as $post){
                        $picture = postmeta::selectPostMeta("post_id = '$post->post_id' AND meta_key = 'featured_img'");
                        $picture_url = $picture? $picture[0]->meta_value:URI_NAME.'/assets/media/noimage.png';
                        $html.='<li class="flex">
                        <a href="'.$post->post_guid.'"><img src="'.$picture_url.'" alt="'.$post->post_title.'" title="'.$post->post_title.'" class="'.$image_style.'" style="min-width:3rem;" alt="'.$post->post_title.'"/></a>
                       <span class="flex w-full"> <a href="'.$post->post_guid.'" class="font-medium text-sm flex f ml-2 text-ellipsis" title="'.$post->post_title.'">'.$post->post_title.'</a></span>
                        </li>';
                    }
                    $html.='</ul>';

                    $response = $html;
                }

                break;

            case 4:
                // Recente articles
                $RecentPosts = post::selectPost("post_type='article' AND post_visibility='public'",$option['num_articles']." OFFSET 0","id DESC",'id,post_title,post_guid,post_date');
                $html = '';
                if($RecentPosts){
                    
                    $html .= '<ul class="flex flex-col gap-3">';
                    foreach($RecentPosts as $post){
                        
                        $picture_url = leemclasses::getFeaturedImage($post->id);
                         $html.='<li class="flex">
                        <a href="'.$post->post_guid.'"> <img src="'.$picture_url.'"  alt="'.$post->post_title.'" title="'.$post->post_title.'" class="'.$image_style.'" style="min-width:3rem;" alt="'.$post->post_title.'"/></a>
                       <label class="flex flex-col w-full"> <span class="ml-2 text-xs text-gray-400">'.(new DateTime("$post->post_date"))->format(leemclasses::option('date_format')).'</span> <a href="'.$post->post_guid.'" class="text-sm text-ellipsis font-medium flex  ml-2 "  title="'.$post->post_title.'">'.$post->post_title.'</a>
                      
                       </label>
                        </li>';
                    }
                    $html.='</ul>';

                    $response = $html;
                }

                break;

            case 5:
                // Category Lists
                $CategoryList = metatags::selectMetaTags("type='category'",'*','name ASC',$option['num_articles']." OFFSET 0");
                $html = '';
                if($CategoryList){
                    
                    $html .= '<ul class="flex flex-col gap-3">';
                    foreach($CategoryList as $category){
                    $quantPost = postmeta::selectPostMeta("meta_key='post_category' AND meta_value='$category->id'"," COUNT(id) AS result ");
                       $quantPost = $quantPost[0]?$quantPost[0]->result:0;
                        
                        $html.='<li class="flex justify-between">
                       <label class="flex flex-col"> <a href="'.metatags::getMetatagGuid("$category->slug","$category->type").'" class="font-medium text-sm flex flex-wrap ml-2">'.$category->name.'</a>
                       </label>
                       <span title="Articles...">('.$quantPost.')</span>
                        </li>';
                    }
                    $html.='</ul>';

                    $response = $html;
                }
                break;
                case 6:
                    $platforms = $option['platform'];
                    $links = [];
                    foreach($platforms as $key=>$value){
                        $link=self::getSocialLink($value);
                        if($link){
                            $link_html = '<a href="'.$link['url'].'"  title="'.$link['name'].'" target="_blank" class="w-8 h-8 '.$option['buttons'].' hvr-grow text-white flex items-center justify-center" style="background:#'.$link['color'].';">
        '.$link['icon'].'
        </a>';
        $links[]=$link_html;
                        }
                    }

                    $html ='<div class="flex gap-3 '.$option['orientation'].'">'.implode("\n",$links).'</div>';
                    $response = $html;
                break;

            default:
                break;
        }
        
        $title_html = $title!=''? '<h4 class="' . $title_css . '">' . $title . '</h4>':'';
        return ['title'=>"$title_html", "content"=>"$response"];
    }

  private static function addom($array, $data)
        {
            return isset($array["$data"]) ? $array["$data"] : null;
        }

    public static function getGadged($id,$addoms = []){
        $widget_content = (new widget())->selectWidget("id='$id'");
        if($widget_content){
            $content = $widget_content[0]->widget_content;
            $content = str_word_count($content)>0? (array) json_decode($content):null;
            return self::getGadgetHTML($content,$addoms);
        }

        return null;
    }


    public static function getSocialLink($platform){
        $links = ['facebook'=>[
            'name'=>'Facebook',
            'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 320 512"><path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/></svg>',
            'color'=>'0866FF',
            'url'=>leemclasses::option('social_link_fa')
        ],
        'x'=>[
            'name'=>'X/Twitter',
            'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>',
            'color'=>'000',
            'url'=>leemclasses::option('social_link_x')
        ],
        'instagram'=>[
            'name'=>'Instagram',
            'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>',
            'color'=>'FF3040',
            'url'=>leemclasses::option('social_link_in')
        ],
        'youtube'=>[
            'name'=>'Youtube',
            'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 576 512"><path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg>',
            'color'=>'FF0000',
            'url'=>leemclasses::option('social_link_yt')
        ],
        'linkedin'=>[
            'name'=>'Linkedin',
            'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 448 512"><path d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z"/></svg>',
            'color'=>'0A66C2',
            'url'=>leemclasses::option('social_link_ln')
        ]];

        return isset($links[$platform])?$links[$platform]:[];
    }

}
