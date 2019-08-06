# wordContrl

#### 介绍
word文档管理工具，具有创建word文档、编辑word文档、将word文档转为文本等功能

#### 软件架构
软件架构说明


#### 安装教程

1. xxxx
2. xxxx
3. xxxx

#### 使用说明


		require("wordControl/wordControl.php");
		
		
		1、创建word文档
		$wordControl = new wordControl();
		
		//创建段落
		$wordControl->createSection(function($wordSection){
			$wordSection->align("center")->spacing(1);
			$wordSection->createText(function($wordText){
				$wordText->text("word测试标题")->size(18)->font("华康标题宋W9(P)")->spacing(0);
			});
		});
		
		$wordControl->createSection(function($wordSection){
			$wordSection->align("center")->spacing(1);
			$wordSection->createText(function($wordText){
				$wordText->text("（2018年7月）")->size(16)->font('楷体')->color('#333333');
			});
		});
		
		$wordControl->createSection(function($wordSection){
			$wordSection->align("left");
			$wordSection->createText(function($wordText){
				$wordText->spacing(60)->text("大家好：");
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
		$wordControl->createXML()->save("123.docx")->output();
		

		2、修改word文档
		
		//解析word文档
		$wordSections = $wordControl->load('./temp.docx')->parseWord();
		
		//获取所有段落对象列表
		$wordSectionList = $wordSections->getWordSectionLists();
		
		$wordSection = $wordSections->getWordSectionItem(0)['section']; //获取指定的段落对象
		
		$wordText = $wordSection->getTextsObj()[0]->text("新的文本内容"); //获取段落对象下面的文本对象并设置新的内容
		$wordSection->updateText($wordText); //修改段落对象下面的文本内容
		
		$wordSection->replaceText('新闻坊','新闻观察'); //替换段落对象下面的文本内容
		
		$wordControl->createXML()->save("1234.docx")->output(); //生成修改后的文档并下载
		
		3、解析word文档返回文本
		
		//解析word文档
		$wordSectionTexts = $wordControl->load('./temp.docx')->parseWord()->getWordSections();
		

#### 参与贡献

1. Fork 本仓库
2. 新建 Feat_xxx 分支
3. 提交代码
4. 新建 Pull Request


#### 码云特技

1. 使用 Readme\_XXX.md 来支持不同的语言，例如 Readme\_en.md, Readme\_zh.md
2. 码云官方博客 [blog.gitee.com](https://blog.gitee.com)
3. 你可以 [https://gitee.com/explore](https://gitee.com/explore) 这个地址来了解码云上的优秀开源项目
4. [GVP](https://gitee.com/gvp) 全称是码云最有价值开源项目，是码云综合评定出的优秀开源项目
5. 码云官方提供的使用手册 [https://gitee.com/help](https://gitee.com/help)
6. 码云封面人物是一档用来展示码云会员风采的栏目 [https://gitee.com/gitee-stars/](https://gitee.com/gitee-stars/)