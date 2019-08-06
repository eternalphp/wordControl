<?php 

require __DIR__ . "/vendor/autoload.php";

use wordControl\wordControl;
use wordControl\wordStyle;

class phpWord{

	public function create(){
		
		$wordControl = new wordControl();
			
		//创建段落
		$wordControl->createSection(function($wordSection){
			$wordSection->align("center");
			$wordSection->createText(function($wordText){
				$wordText->text("东方明珠OPG_HR接口规范文档")->size($wordText->getFontSize("二号"))->font("微软雅黑")->spacing(0)->bold();
			});
		});
		
		$wordControl->createSection(function($wordSection){
			$wordSection->align("center");
			$wordSection->createText(function($wordText){
				$wordText->text("V1.0")->size($wordText->getFontSize("五号"))->font('微软雅黑')->color('#333333')->bold();
			});
		});
		
		$wordControl->createSection(function($wordSection){
			$wordSection->align("center");
			$wordSection->createText(function($wordText){
				$wordText->text("2018-12-12")->font("Tahoma")->size(11)->bold();
			});
			
		});
		
		$wordControl->createSection(function($wordSection){
			$wordSection->pStyle();
			$wordSection->createText(function($wordText){
				$wordText->text("1、个人信息查询")->font("微软雅黑")->size($wordText->getFontSize("二号"))->bold();
			});
			
		});
		

		//创建公共样式
		$this->wordStyle = new wordStyle();
		$this->wordStyle->size(16)->font('仿宋_GB2312')->color('#ff0000')->spacing(16);

		//创建段落并定义为模板
		$wordControl->createSection(function($wordSection){
			$wordSection->align("left")->ind(2);
			$wordSection->createText(function($wordText){
				$wordText->style($this->wordStyle)->text("测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容");
			});
		})->createTemplate('content');

		//创建段落并定义为模板
		$wordControl->createSection(function($wordSection){
			$wordSection->align("left")->ind(2);
			$wordSection->createText(function($wordText){
				$wordText->style($this->wordStyle)->color("#00ff00")->text("测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容");
			});
		})->createTemplate('content1');

		//使用模板并设定内容
		$wordControl->templateText('content','我是模板内容我是模板内容我是模板内容我是模板内容我是模板内容我是模板内容我是模板内容我是模板内容');

		//使用模板并设定内容
		$wordControl->templateText('content1','测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容');


		$wordControl->createSection(function($wordSection){
			$wordSection->align("left")->ind(2);
			$wordSection->createText(function($wordText){
				$wordText->text("表格标题：")->font('黑体')->size(16)->spacing(0)->bold();
			});
		});
		
		//创建表格
		$wordControl->createTable(function($wordTable){
			
			//设置表格边框样式
			$wordTable->borders(function($wordTableBorders){
				$wordTableBorders->get('left')->size('10')->color("ff0000");
				$wordTableBorders->get('right')->size('10')->color("ff0000");
				$wordTableBorders->get('top')->size('10')->color("00ff00");
				$wordTableBorders->get('bottom')->size('10')->color("00ff00");
			});
			
			//创建表格行
			$wordTable->createRow(function($wordTableRow){
				
				//创建表格列
				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("姓  名")->bold();
						});
					});
				});

				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("出生日期")->bold();
						});
					});
					
				});

				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("年  龄")->bold();
						});
					});
				});

				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("课 程")->bold();
						});
					});
				});

				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("得  分")->bold();
						});
					});
				});
			
			});
			
			//创建表格行并为此行创建模板
			$wordTable->createRow(function($wordTableRow){
				
				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("学生1")->color("#ff0000");
						});
					});
				});

				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("2015-01-02");
						})->align('center');
					});
					
				});

				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("3");
						});
					});
				});

				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("语文")->bold()->underline();
						});
					});
				});

				$wordTableRow->createCell(function($wordTableCell){
					$wordTableCell->width(1000);
					$wordTableCell->createSection(function($wordSection){
						$wordSection->createText(function($wordText){
							$wordText->text("100")->color("#00ff00");
						});
					});
				});
			
			})->createTemplate('row');
			
			//使用表格行模板创建行
			$wordTable->templateText('row',array('学生3','2015-01-05','3','数学','98'));
			$wordTable->templateText('row',array('学生4','2015-01-06','3','数学1','100'));
			$wordTable->templateText('row',array('学生5','2015-01-07','3','数学3','94'));
		});
		
		//使用模板并设定内容
		$wordControl->templateText('content1','内容结尾内容结尾内容结尾内容结尾内容结尾内容结尾内容结尾内容结尾内容结尾内容结尾内容结尾');
		
		//生成表格并下载
		$wordControl->createXML()->save("123.docx");
	
	}
	
}

(new phpWord())->create();

?>