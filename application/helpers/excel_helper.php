<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'third_party/Classes/PHPExcel.php');

function export_to_excel($filename, $data, $column_names) {
    // Tạo đối tượng PHPExcel
    $objPHPExcel = new PHPExcel();
    
    // Đặt tiêu đề sheet
    $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
    
    // Đặt tên các cột
    $column = 'A';
    foreach ($column_names as $name) {
        $objPHPExcel->getActiveSheet()->setCellValue($column . '1', $name);
        $column++;
    }
    
    // Đặt dữ liệu
    $row = 2;
    foreach ($data as $rowData) {
        $column = 'A';
        foreach ($rowData as $cellData) {
            $objPHPExcel->getActiveSheet()->setCellValue($column . $row, $cellData);
            $column++;
        }
        $row++;
    }
    
    // Tạo file Excel và trả về
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}
