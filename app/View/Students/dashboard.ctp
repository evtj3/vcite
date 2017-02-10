<?php $serverName = $_SERVER['SERVER_NAME'];?>
<div class="teachers index">

	<div class="row" >
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li class="active"><span class="glyphicon glyphicon-home"></span></li>
				<li class="active">
					<a href="<?php echo $this->Html->url(array('controller'=>'students','action'=>'students_profile'));?>"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Welcome <?php echo $this->Session->read('User.wholename');?>!</a>
				</li>
			</ol>
		</div>
	</div>
	<div style="width:92%; margin:0 auto; text-align:right; padding:5px 5px 5px 5px;">
			<?php
			/*
			#pr($this->data);
				echo $this->Form->create('Topics',array('action'=>'searched_data','type' => 'get'));
				echo '<input type="text" name="searcher" style="width:100%; font-style:italic; text-align:right; padding:5px;" placeholder="search a topic here"/>';
				#echo $this->Form->submit();
				echo $this->Form->end();
				*/
			?>
		</div>
		<div class="col-md-13">
			<div class="actions">
				<div class="panel panel-default">
					<p style="text-align:right; font-style:italic; font-size:10px; padding:5px;">Created by Admin, If you have any concern about the mainpage's content please ask the administrator for the update.</p>
					<div class="con_heading">Main Page</div>
					
						<div class="con_body">
								<div class="row" >
									<!--
									<div class="col-md-6">
										<h3>Subjects - <font style="font-size:12px;color:#fff; "><?php echo '<span style="background-color:#77CBDE; padding:4px 8px 4px 8px;
											border-radius: 10px 10px 10px 10px;
											-moz-border-radius: 10px 10px 10px 10px;
											-webkit-border-radius: 10px 10px 10px 10px;
										">'.$countSubjects.'</span>';?></font></h3>
											<ul class="los">
												<?php echo $listOfSubject;
												?>
											</ul>
									</div>
									-->
									<div class="col-md-6">
										<h3>Latest Assesstment taken - <font style="font-size:12px;color:#fff; "><?php echo '<span style="background-color:#77CBDE; padding:4px 8px 4px 8px;
											border-radius: 10px 10px 10px 10px;
											-moz-border-radius: 10px 10px 10px 10px;
											-webkit-border-radius: 10px 10px 10px 10px;
										">'.$countAssTaken.'</span>';?></font></h3>
											<ul class="los">
											<?php echo $listOfAssestments;?>
											</ul>
									</div>

									
								</div>
								<div class="row" >
									<div class="col-md-6">
										<h3>Links</h3>
											<ul class="los">
											<a href="http://cite.edu.ph"><li style="list-style:none;"><span class="glyphicon glyphicon-globe"></span> CITE Official Website</li></a>
											<a href="<?php echo "http://".$serverName."/cis";?>"><li style="list-style:none;"><span class="glyphicon glyphicon-link"></span> CIS (CITE Integrated System)</li></a>
											</ul>
									</div>
									<div class="col-md-6">
										<h3>Documentations</h3>
											<ul class="los">
											<?php if($this->Session->read('User.group') != "student"):?>
											<a target="_blank" href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Math Formula guide/LaTeXSymbols.pdf">
						                    <li style="list-style:none;"><span class="glyphicon glyphicon-file"></span> LaTeX Mathematical Symbols</li>
						                  </a>
						                  	<a href="<?php echo $this->Html->url(array('controller' => 'documents','action' => 'index'));?>">
						                    <li style="list-style:none;"><span class="glyphicon glyphicon-briefcase"></span> ISO (International Standards Organization)</li>
						                  </a><?php endif?>
						                  <a href="<?php echo $this->Html->url(array('controller' => 'lasdocs','action' => 'index'));?>">
						                    <li style="list-style:none;"><span class="glyphicon glyphicon-briefcase"></span> LAS (Learning Activity Sheet)</li>
						                  </a>
						                  <!--
						                  <a href="<?php echo $this->Html->url(array('controller' => 'otherresources','action' => 'index'));?>">
						                    <li style="list-style:none;"><span class="glyphicon glyphicon-briefcase"></span> Other resources</li>
						                  </a>
						                  -->
						                  <!--<a href="<?php echo $this->Html->url(array('controller' => 'ebooks','action' => 'index'));?>">
						                    <li style="list-style:none;"><span class="glyphicon glyphicon-book"></span> Ebooks</li>
						                  </a>-->
											</ul>
									</div>
									
									<hr/>
								
								
									<div class="col-md-12">
										<h3>E-books <label id="chevronUpDown"><span class="glyphicon glyphicon-chevron-down" style="cursor:pointer; border:solid 1px #cecece; padding:5px; margin-left:10px; font-size:14px;" ></span> <font style="cursor:pointer; border:solid 1px #cecece; padding:3px; font-size:12px;">show</font> </label></h3>
											
											<div class="col-md-12" id="eBookguide" style="font-style:italic; font-size:12px;">click the <strong>arrow</strong> or <strong>show</strong> button to display the electronic books
											</div>
											
											<ul class="los" id="ebookFiles" style="display:none;">
												<div class="col-md-4">
													<li style="list-style:none;">Pope Benedict XVI
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Catechism_Compendium.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Compendium of the Catechism of the Catholic Church
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">Rev. Fr. M. Guzman 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/QA_gutualgaropelflorentino.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Question & Answer Catholic Catechism
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">Arthur Conan Doyle 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Hound_of_Baskervilles.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Hound of Baskervilles
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Lost_World.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Lost World
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">Charles Dickens 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/A_Christmas_Carol.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		A Christmas Carol
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/A_tale_of_two_cities_charles_d.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		A Tale of Two Cities
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Great_expectations_charles_dic.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Great Expectations
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Oliver_twist_charles_dickens.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Oliver Twist
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Three_ghost_stories_charles_di.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Three Ghost Stories
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">D'Artagnan Stories 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/1The_Three_Musketeers.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Three Musketeers
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/2Twenty_Years_After.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Twenty Years After
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/3The_Vicomte_de_Bragelonne.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Vicomte De Bragelonne
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/4Louise_de_la_Valliere.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Louise De La Valliere
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/5The_Man_in_the_Iron_Mask.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Man In The Iron Mask
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">JRR Tolkien  
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Farmer_Giles_Of_Ham.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Farmer Giles Of Ham
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/History_Of_Middle_Earth.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		History Of Middle-Earth
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/JRR_Tolkien_Elven_Phrases.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Elven Phrases
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Parma_Endorion_Essays_On_Middl.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Parma Endorion - Essays On Middle Earth 
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Hobbit.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Hobbit 
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Silmarillion_illustrated_ve.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Silmarillion (Illustrated version)
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_fellowship_of_the_ring_part1.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Fellowship Of The Ring Part1
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_fellowship_of_te_ring_part2.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Fellowship Of The Ring Part2
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">Twilight 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Stephenie_Meyer_Twilight_01_Tw.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Twilight
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Meyer_Stephenie_Twilight_02_N.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																	Twilight New Moon
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Stephenie_Meyer_Twilight_03_.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Twilight Eclipse
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Twilight_4_Breaking_Dawn_Steph.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																	Twilight Breaking Dawn
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">King Arthur Books  
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/In_the_Court_of_King_Arthur.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		In The Court Of King Arthur
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/King_Arthur_and_His_Knights.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		King Arthur And His Knights
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Legends_of_King_Arthur_and_H.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Legends Of King Arthur And His Knights
																</li>
															</a>
														</ul>
													</li>
												</div>
												<div class="col-md-4">
													<li style="list-style:none;">CS Lewis 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/1150_the_chronicles_of_narnia_al.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The-Chronicles-Of-Narnia-All-Books
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/9490_the_lion_the_witch_and_the_.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The-Lion-The-Witch-And-The-Wardrobe
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/9493_prince_caspian.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Prince-Caspian
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/9494_the_voyage_of_the_dawn_trea.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The-Voyage-Of-The-Dawn-Treader
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/9497_the_horse_and_his_boy.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The-Horse-And-His-Boy
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/9500_the_magician_s_nephew.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The-Magician-S-Nephew
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/9501_the_last_battle.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The-Last-Battle
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Chronicles_of_Narnia.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Chronicles of Narnia
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Spirits_in_Bondage_cs_lewis.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Spirits In Bondage
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">Christopher Paolini 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Brisingr.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Brisingr
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Eldest.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Eldest
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Eragon.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Eragon 
																</li>
															</a>
															
														</ul>
													</li>
													<li style="list-style:none;">Fyodor Dostoevsky 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Crime_and_punishment_fyodor_do.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Crime And Punishment
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Notes_from_the_underground_fyo.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Notes From The Underground
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_brothers_karamazov_fyodor_.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Brothers Karamazov
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_idiot_fyodor_dostoevsky.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The idiot 
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">HG Wells 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_island_of_dr_moreau_hg_wel.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Island Of Dr Moreau 
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_time_machine_hg_wells.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Time Machine
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_War_of_the_Worlds_hg_wells.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The War Of The Worlds
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">Homer 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_iliad_homer.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Iliad
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_odyssey_homer.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Odyssey
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">Mark Twain 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_adventures_of_huckleberry_fi.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Adventures Of Huckleberry Finn
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_adventures_of_tom_sawyer_m.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Adventures Of Tom Sawyer
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Prince_and_the_Pauper_mark.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		The Prince And The Pauper
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">Robert Louis Stevenson 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Kidnapped_robert_louis_stevens.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Kidnapped
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_strange_case_of_dr_jekyll_an.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																	The Strange Case Of Dr Jekyll And Mr Hyde
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Treasure_island_robert_louis_s.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Treasure Island
																</li>
															</a>
														</ul>
													</li>
													<li style="list-style:none;">Leo Tolstoy 
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Anna_karenina_leo_tolstoy.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Anna Karenina
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/War_and_Peace_leo_tolstoy.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		War and Peace
																</li>
															</a>
														</ul>
													</li>
												</div>
												<div class="col-md-4">
													<li style="list-style:none;">William Shakespeare  
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Hamlet_william_shakespeare.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Hamlet
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Macbeth_william_shakespeare.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																	Macbeth
																</li>
															</a>
															
														</ul>
													</li>
													<li style="list-style:none;">Others  
														<ul>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Alice_in_Wonderland.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Alice In Wonderland
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Alices_adventures_in_wonderland_.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																	Alices Adventures In Wonderland - Lewis Carol
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Ana_Karenina.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																		Ana Karenina
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Andersens_fairy_tales_hc_ander.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																	Andersens Fairy Tales - HC Andersen
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Around_the_world_in_80_days_ju.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Around The World In 80 Days - Jules Verne
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Beowulf.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Beowulf
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Count_of_Monte_Cristo.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																WCount Of Monte Cristo
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Don_quixote.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Don Quixote
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Dracula_bram_stoker.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Dracula - Bram Stoker
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Essays_ralph_waldo_emerson.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Essays - Ralph Waldo Emerson
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Frankenstein_mary_shelleys.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Frankenstein - Mary Shelleys
																</li>
															</a> 
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Grimms_fairy_tales_brothers_gr.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Grimms Fairy Tales - Brothers Grimm
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Robinson_crusoe_daniel_defoe.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Robinson Crusoe - Daniel Defoe
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Art_of_War_sun_tzu.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Art Of War - Sun Tzu
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Catcher_in_the_Rye_JD_Sali.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Catcher In The Rye - JD Salinger
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Count_of_Monte_Cristo.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Count Of Monte Cristo
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Illiad.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Illiad
																</li>
															</a> 
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_jungle_book_rudyard_kiplin.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Jungle Book - Rudyard Kipling
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_last_of_the_mohicans_janes.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Last Of The Mohicans - Janes Fenimoore Cooper
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Last_of_the_Mohicans.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Last Of The Mohicans
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_legend_of_sleepy_hollow_wa.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Legend Of Sleepy Hollow - Washington Irving
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Merry_Adventures_of_Robin_Ho.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Merry Adventures Of Robin Hood - Howard Pyle
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_merry_adventures_of_robin_ho.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Merry Adventures Of Robin Hood
																</li>
															</a> 
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Odyssey.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Odyssey
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_red_badge_of_courage_steph.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Red Badge Of Courage - Stephen Crane
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_scarlett_letter_nathaniel_.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Scarlett Letter - Nathaniel Hawthorne
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/The_Works_of_Edgar_Allan_Poe.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																The Works Of Edgar Allan Poe
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Ulysses_james_joyce.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Ulysses - James Joyce
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/Utopia_thomas_more.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																Utopia - Thomas More
																</li>
															</a>
															<a href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Ebooks/White_Fang.pdf">
																<li><span class="glyphicon glyphicon-file"></span>
																White Fang
																</li>
															</a>
														</ul>
													</li>
												</div>	
											</ul>
											<!---->
									</div>

									
								
								<!---->
									<div class="col-md-12">
										
										
										<?php 
										 echo '<div class="col-md-12 main_content">';
											
											
												#pr($mainPage);

												$content = $mainPage['Topic']['content'];
													$pdfs = '';
													
													$pdfs = str_replace('[PDF_EMBED|', '<a href="',$content);
													$pdfs = str_replace('|PDF_EMBED]', '">Check this PDF</a>',$pdfs);

													$content = str_replace('[PDF_EMBED|', '<object width="100%" height="800px" type="application/pdf" data="', $content);
													


					                                $content = str_replace('|PDF_EMBED]', '#toolbar=1&scrollbar=1">
					    It appears you don\'t have Adobe Reader or PDF support in this web browser. '.$pdfs.'</object>', $content);

					                               	
					                               //pr($pdfs);
					                                echo $content;
				                              
											
											echo '</div>';

											
											//pr($_POST);
										?>
										
									</div>
								</div>
									
								
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->
		<div class="col-md-2">
		</div>
	</div>
	
	<div class="row">
		<div class="con_separator">
			<h1>Mission</h1>
				<h4>The CITE Technical Institute, Inc., is an institution committed to provide training in technical skills and entrepreneurship, values formation, health and social services to the less privileged youth, their families, the local community and the industrial sector of Visayas and Mindanao. We aim to develop in them a high sense of professionalism and a deep Christian and social oriented spirit.
				</h4>
			<h1>Vision</h1>
				<h4>We envision CITE Technical Institute, Inc. to be an educational institution that provides technical training to the less priveleged youth in a manner that is always deeply rooted in moral and work values, strongly linked with families and industry, and extensively imbued with the entrepreneurial spirit.
				</h4>
		</div>
	</div>
	
	<div class="row" >
		<div class="col-md-13" >
			<div class="motto_con">
				<p class="motto">"We do ordinary things extraordinarily well"</p>
				<p class="motto_sub">-CITE-</p>
			</div>
			
		</div>
	</div>
   <!-- -->
</div><!-- end containing of content -->
<script>
var count = 0;
	$('#chevronUpDown').click(function () {
		
		count += 1;

		if(count >= 3){
			count = 1;
		}

		if(count == 1){
			$('#chevronUpDown').html('<span class="glyphicon glyphicon-chevron-up" style="cursor:pointer; border:solid 1px #cecece; padding:5px; margin-left:10px; font-size:14px;" ></span> <font style="cursor:pointer; border:solid 1px #cecece; padding:3px; font-size:12px;">hide</font> ');
			$('#ebookFiles').slideDown('slow');
			$('#eBookguide').fadeOut(300);
		}

		if(count == 2){
			$('#chevronUpDown').html('<span class="glyphicon glyphicon-chevron-down" style="cursor:pointer; border:solid 1px #cecece; padding:5px; margin-left:10px; font-size:14px;" ></span> <font style="cursor:pointer; border:solid 1px #cecece; padding:3px; font-size:12px;">show</font> ');
			$('#ebookFiles').slideUp('slow');
			$('#eBookguide').fadeIn(300);
		}

	});
</script>