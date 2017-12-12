<?php

namespace app\extend\PHPExcel;

require 'PHPExcel.php';

/**
 * Excel操作类
 *
 * @filename Excel.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-8-12 10:12:33
 */
class Excel extends \PHPExcel {

    // 单例
    public static $instance;

    public static function getInstance() {
        if (empty(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    /**
     * 获取Excel表单数据
     * 说明：通常来说，数据量不是很大（多大算大？）按照这种方式一次性读入内存中是没什么关系的，
     * 扩展提供了文件迭代器协议的方式循环读取，可参见开头给出的慕课网免费视频，几乎常用的都提到了
     * @param int $inFile 读取文件路径
     * @param bool $index 读取表格索引，默认读取所有数据 合并后返回
     * @return array
     */
    public function readSheet($inFile, $index = false) {
        // 得到文件类型
        $type = \PHPExcel_IOFactory::identify($inFile);
        $reader = \PHPExcel_IOFactory::createReader($type);
        // 导入文件
        $sheet = $reader->load($inFile);
        // 获取文件中表格sheet的数量
        $sCount = $sheet->getSheetCount();
        // 如果指定了获取某一个子表格（表格中，可能有多个子表格）的数据，转化为数组返回
        if (is_int($index) && $index < $sCount && $index >= 0) {
            return $sheet->getSheet($index)->toArray();
        }
        // 只有一个子表格
        if ($sCount == 1) {
            return $sheet->getSheet(0)->toArray();
        }
        $data = [];
        // 所有表格数据全部以数组格式返回
        for ($i = 0; $i < $sCount; $i++) {
            $data[] = $sheet->getSheet($i)->toArray();
        }
        unset($sheet, $reader, $type);

        return $data;
    }

    /**
     * 将数据保存至Excel表格
     * 说明：只是一个子表时请自行处理，道理类似
     * @param string $outFile 要保存的文件路径
     * @param array $data 需要保存的数据 二维数组
     * @param string $saveType  保存类型
     * @return bool
     */
    public function saveSheet($outFile, array $data, $saveType = 'down') {
        $path = explode('/', $outFile);
        $fielName = $path[count($path) - 1];
        unset($path[count($path) - 1]);
        // DIRECTORY_SEPARATOR 常量是框架定义的目录分隔符，（服务器环境自知，可以不用这么麻烦）
        $path = implode('/', $path) . DIRECTORY_SEPARATOR;
        //目录不存在 则创建目录 需要父目录有写权限才可以创建子目录，
        // Linux基础现在几乎都多多少少会了，不再是什么高深的知识
        if (!file_exists($path)) {
            @mkdir($path, 0777, TRUE);
            @chmod($path, 0777);
        }

        // 实例化一个PHPExcel对象
        $newExcel = new \PHPExcel();
        // 得到一个默认的激活表格，预备写入数据
        $newSheet = $newExcel->getActiveSheet();
        $newSheet->fromArray($data);
        // 格式按自己需要，源码文件样例中有写，（下面这个其实是excel2003的标准）
        $objWriter = \PHPExcel_IOFactory::createWriter($newExcel, 'Excel5');
        switch ($saveType) {
            case 'down': {
                    self::writeHeader($fielName);
                    $objWriter->save("php://output");
                    break;
                }
            case 'local': {
                    $objWriter->save(iconv('utf-8', 'gb2312', $outFile));
                    break;
                }
            case 'all': {
                    self::writeHeader($fielName);
                    $objWriter->save(iconv('utf-8', 'gb2312', $outFile));
                    $objWriter->save("php://output");
                    break;
                }
        }        
        unset($objWriter, $newSheet, $newExcel);
        return true;
    }

    /**
     * @param array $data 需要过滤处理的数据 二维数组
     * @param int $cols  取N列
     * @param int $offset  排除 N 行，比如读取一个表格数据时，标题这一行可能是不希望读出来的，
     *                     毕竟这部分和存入数据库中没什么关系，就排除这一行
     * @param bool|int $must 某列不可为空  0 - index
     * @return array
     */
    public function handleSheetArray(array $data, $cols = 10, $offset = 1, $must = false) {
        $final = [];
        if ($must && $must >= $cols) {
            $must = false;
        }

        foreach ($data as $key => $row) {
            if ($key < $offset) {
                continue;
            }
            $t = [];
            for ($i = 0; $i < $cols; $i++) {
                if (isset($row[$i])) {
                    $t[$i] = trim(strval($row[$i]));
                } else {
                    $t[$i] = '';
                }
            }
            if (is_array($row) && implode('', $t) && ($must === false || $t[$must])) {
                $final[] = $t;
                continue;
            }
        }

        return $final;
    }
    
    private function writeHeader($title){
        header("Pragma: public");
        header("Expires: 0");
        header('Content-Type: application/vnd.ms-excel;charset=utf8');
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename=" . urlencode($title));
        header("Content-Transfer-Encoding:binary");
    }

}
