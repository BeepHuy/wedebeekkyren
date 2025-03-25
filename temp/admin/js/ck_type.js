/*----------------CKEDITOR------------------------
-------------------------------------------------*/
if ( typeof CKEDITOR == 'undefined' )
{
    document.write("khong ") ;
}
else
{
    if (document.getElementById("soanthao")) {
        var editor = CKEDITOR.replace( 'soanthao' );            
        CKFinder.setupCKEditor( editor, base_url+'ckeditor/ckfinder/' ) ; 
    }
    if (document.getElementById("soanthao1")) {
        var editor1 = CKEDITOR.replace( 'soanthao1' );            
        CKFinder.setupCKEditor( editor1, base_url+'ckeditor/ckfinder/' ) ;  
    }
    if (document.getElementById("soanthao2")) {
        var editor2 = CKEDITOR.replace( 'soanthao2' );            
        CKFinder.setupCKEditor( editor2, base_url+'ckeditor/ckfinder/' ) ;  
    }
    if (document.getElementById("soanthao3")) {
        var editor3 = CKEDITOR.replace( 'soanthao3' );            
        CKFinder.setupCKEditor( editor3, base_url+'ckeditor/ckfinder/' ) ;  
    }
    if (document.getElementById("soanthao4")) {
        var editor4 = CKEDITOR.replace( 'soanthao4' );            
        CKFinder.setupCKEditor( editor4, base_url+'ckeditor/ckfinder/' ) ;  
    }
    if (document.getElementById("soanthao5")) {
        var editor5 = CKEDITOR.replace( 'soanthao5' );            
        CKFinder.setupCKEditor( editor5, base_url+'ckeditor/ckfinder/' ) ;  
    }
    if (document.getElementById("soanthao6")) {
        var editor6 = CKEDITOR.replace( 'soanthao6' );            
        CKFinder.setupCKEditor( editor6, base_url+'ckeditor/ckfinder/' ) ;  
    }
              	
}
/*---NUT UPLOAD CKE-RIENT K CAN THI VAN UP O PHAN VIET BAI DC---------
--------------------------------------------------------------------*/
function BrowseServer(){
var finder = new CKFinder();
finder.basePath = '../';	// The path for the installation of CKFinder (default = "/ckfinder/").
finder.selectActionFunction = SetFileField;
finder.popup();                    	
}
function SetFileField( fileUrl )
{
document.getElementById( 'xFilePath' ).value = fileUrl;
}
                                
	