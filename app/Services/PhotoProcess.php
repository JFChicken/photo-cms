<?php

namespace App\Services;

use App\Models\FileVault as FileVaultModel;


class PhotoProcess
{

    protected $rootDir = 'public/photos';

    protected $fileVaultModel;

    public function __construct(FileVaultModel $fileVault)
    {
        $this->fileVaultModel = $fileVault;
    }

    static public function processRecords()
    {
        $urls = [
            1=>[
                
                    'image'=>"storage/photos/2019/fire/stormyFire-1294.jpg",
                    'thumbnail'=>"storage/thumbnails/2019/fire/stormyFire-1294.jpg",
                
            ],
            2=>[
                'image'=>"storage/photos/2019/fire/stormyFire-1296.jpg",
                'thumbnail'=>"storage/photos/2019/fire/stormyFire-1296.jpg",
            ],
            4=>[
                'image'=>"storage/photos/2019/fire/stormyFire-1298.jpg",
                'thumbnail'=>'storage/photos/2019/fire/stormyFire-1298.jpg',
                
            ],
            5=>[
                'image'=>"storage/photos/2019/fire/stormyFire-1299.jpg",
            'thumbnail'=>"storage/photos/2019/fire/stormyFire-1299.jpg",
        ],
        8=>[
            'image'=>"storage/photos/2019/fire/stormyFire-1301.jpg",
            'thumbnail'=>"storage/photos/2019/fire/stormyFire-1301.jpg",
        ] 
        ];
$data =[];
foreach ($urls as $key=>$url){
    
$data[$key]=$url;


}

        return $data;
        
    }

}
