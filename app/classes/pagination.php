<?php
namespace App\classes;


class pagination{

    public $registers;
    public $where;
    public $page;
    public $pageName;
    public $tablename;
    public $results;
    public $styling;

    public function __construct($dirname,$page,$tableName,$numberOfRegisters,$where,$results=false,$styling=false)
    {
        $this->registers = $numberOfRegisters;
        $this->where = $where;
        $this->page = $page;
        $this->pageName = $dirname;
        $this->tablename = $tableName;
        $this->results = $results;
        $this->styling['bg']=$styling?'pagination-styling':'bg-purple-600';
        $this->styling['text']=$styling?'':'text-white';

    }

    


   public function getPagination(){
    $pg_num = (new leemclasses())->pagination($this->tablename,$this->registers,$this->where,$this->results);
    $pg_HTML='';
    
    //PREPARE QUERIES
    $pageKey = $this->pageName;    
    $queryes = leemclasses::checkQueryes();


    $page = $this->page;
    if($pg_num>1){
        $pg_HTML.='<div class="grid px-4  text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    <span class="flex items-center col-span-3">Showing '.$this->registers.' - '.$page.' of '.$pg_num.'</span>';
                    $pg_HTML.='<span class="col-span-2"></span>
                                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                                    <nav aria-label="Table navigation">
                                    <ul class="inline-flex items-center">';
        if($page){
            if($page>1){
                $pg_HTML.='<li>
                <a href="'.URI_NAME.$pageKey.'?page='.($page-1).''.$queryes.'" class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                              </svg>
                </a>
              </li>';
            }else{
                $pg_HTML.='<li>
                <a disabled class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                              </svg>
                </a>
              </li>';
            }
        }else{
            $pg_HTML.='<li class="page-item disabled">
                <a class="page-link">Previous</a>
              </li>';
        }
    
        if($page>2){
            $i=$page-1;
        }else{
            $i=1;
        }
        $y=1;
        
        do{
            if($i>=$pg_num){
                $y=6;
            }
            $active = $i==$page?'px-3 py-1 '.$this->styling['bg']." ".$this->styling['text'].' transition-colors duration-150  border-none  rounded-md focus:outline-none focus:shadow-outline-purple':'px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple';
        
            
            $pg_HTML.='<li><a class="'.$active.'" href="'.URI_NAME.$pageKey.'?page='.$i.''.$queryes.'">'.$i.'</a></li>';
            $i++;
            $y++;
        }while($y<=5);
    
        if($page<$pg_num){
            $pg_HTML.='<li>
            <a class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
            aria-label="Next" href="'.URI_NAME.$pageKey.'?page='.($page+1).''.$queryes.'">
                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </a>
          </li>';
        }
        
        $pg_HTML.='</ul>
                </nav>
            </span>
            </div>
        </div>';
    
    }

    return $pg_HTML;

    }
}