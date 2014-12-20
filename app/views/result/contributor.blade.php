<div id="page-wrapper">
	<div class="container-fluid top-buffer">
		<div class="row thaibold">
            <div class="col-lg-10 col-lg-offset-1">
            	<div class="col-lg-4 col-md-6 col-sm-6">
            		<h3 style="text-align:center;">มีผู้ติดตามมากที่สุด</h3>
					<div class="panel panel-red">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3">
					                <a href="http://twitter.com/Prasong_lert" class="avatar" target="_blank"><img alt="Prasong_lert" src="http://pbs.twimg.com/profile_images/467959978716692481/fcU2IIey_normal.jpeg" /></a>
					            </div>
					            <div class="col-xs-9 text-right">
					            	<div class="huge">32.4k</div>
					                <div>followers</div>
					            </div>
					        </div>
					    </div>				 
					    <a href="http://twitter.com/Prasong_lert">
					        <div class="panel-footer">
					            <span class="pull-left">@Prasong_lert</a></span>
					            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					            <div class="clearfix"></div>
					        </div>
					    </a>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6">
					<h3 style="text-align:center;">ถูกรีทวีตมากที่สุด</h3>
					<div class="panel panel-primary">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3">
					                <a href="http://twitter.com/mmppz" class="avatar" target="_blank"><img alt="mmppz" src="http://pbs.twimg.com/profile_images/482577002927366144/xUB3iuIF_normal.jpeg" /></a>
					            </div>
					            <div class="col-xs-9 text-right">
					            	<div class="huge">12</div>
					                <div>retweets</div>
					            </div>
					        </div>
					    </div>
					    <a href="http://twitter.com/mmppz">
					        <div class="panel-footer">
					            <span class="pull-left">@mmppz</a></span>
					            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					            <div class="clearfix"></div>
					        </div>
					    </a>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6">
					<h3 class="onlythaibold" style="text-align:center;">มีส่วนร่วมมากที่สุด</h3>
					<div class="panel panel-yellow">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3">
					                <a href="http://twitter.com/Tlezwinyu" class="avatar" target="_blank"><img src="http://pbs.twimg.com/profile_images/353858022/sopon_normal.jpg" alt="iiDudes" class="avatar"></a>
					            </div>
					            <div class="col-xs-9 text-right">
					            	<div class="huge">15</div>
					                <div>tweets</div>
					            </div>
					        </div>
					    </div>
					    <a href="http://twitter.com/Tlezwinyu">
					        <div class="panel-footer">
					            <span class="pull-left">@Tlezwinyu</a></span>
					            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					            <div class="clearfix"></div>
					        </div>
					    </a>
					</div>
				</div>
                <!-- <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3>ผู้ติดตามสูงที่สุด</h3>
                    <div class="col-lg-6"><img src="http://pbs.twimg.com/profile_images/482577002927366144/xUB3iuIF_normal.jpeg"></img></div>
                    <div class="col-lg-6"><h1>Chatchamon Writer</h1><h3>1,048 คน</h3></div>
                </div> 
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3>ถูกรีทวีตมากที่สุด</h3>
                    <div class="col-lg-6"><span class="glyphicon glyphicon-user" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6"><h1>472</h1><h3>คน</h3></div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3>ถูก mention มากที่สุด</h3>
                    <div class="col-lg-6"><span class="glyphicon glyphicon-eye-open" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6"><h1>32,599</h1><h3>ครั้ง</h3></div>
                </div> -->
            </div>
        </div>

        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h3 class="panel-title thaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> ผู้ใช้ที่เกี่ยวข้องทั้งหมด</h3>
                </div>
                <div class="panel-body" style="min-height: 425px; max-height: 425px; overflow-y: scroll;">
                    <div class="row onlythaibold" style="font-size:20px;">
                    	<p style="margin-left:20px;">เลือกดูผู้ใช้ที่&nbsp;
	                   		<input id="cb1" type="checkbox" value="1" onchange="valueChanged()" checked /> Tweet&nbsp;
	                   		<input id="cb2" type="checkbox" value="1" onchange="valueChanged()" checked /> Retweet&nbsp;
	                   		<input id="cb3" type="checkbox" value="1" onchange="valueChanged()" checked /> Reply&nbsp;
                   		</p>
                    </div>	
                    

					<script type="text/javascript">
						function valueChanged()
						{
						    var x=0;
						    if($('#cb1').is(":checked")) x+=1;
						    x*=2;
						    if($('#cb2').is(":checked")) x+=1;
						    x*=2;
						    if($('#cb3').is(":checked")) x+=1;
						    var name="#table"+x;
						    $(".contributorTable").hide();
						    $(name).show();
						
						}
					</script>

					<div class="table-responsive contributorTable" id="table0" style="display: none;">

					</div>

					<div class="table-responsive contributorTable" id="table1" style="display: none;">
						<table class="table table-hover table-striped">
					        <thead>
					          	<th>&nbsp;</th>
					          	<th>Tweets</th>
					          	<th>RTs</th>
					          	<th>Followers</th>
					        </thead>
					        <tbody>					          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/thailand_jp">show only reply</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>8.5k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/JBGOT7_Thailand">JBGOT7_Thailand</a></td>
						            <td>2</td>
						            <td>0</td>
						            <td>6.6k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/CollectedN">CollectedN</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>5.1k</td>
						          </tr>
						    </tbody>
						</table>
					</div>

					<div class="table-responsive contributorTable" id="table2" style="display: none;">
						<table class="table table-hover table-striped">
					        <thead>
					          	<th>&nbsp;</th>
					          	<th>Tweets</th>
					          	<th>RTs</th>
					          	<th>Followers</th>
					        </thead>
					        <tbody>					          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/thailand_jp">show only retweet</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>8.5k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/JBGOT7_Thailand">JBGOT7_Thailand</a></td>
						            <td>2</td>
						            <td>0</td>
						            <td>6.6k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/CollectedN">CollectedN</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>5.1k</td>
						          </tr>
						    </tbody>
						</table>
					</div>

					<div class="table-responsive contributorTable" id="table3" style="display: none;">
						<table class="table table-hover table-striped">
					        <thead>
					          	<th>&nbsp;</th>
					          	<th>Tweets</th>
					          	<th>RTs</th>
					          	<th>Followers</th>
					        </thead>
					        <tbody>					          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/thailand_jp">show retweet and reply</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>8.5k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/JBGOT7_Thailand">JBGOT7_Thailand</a></td>
						            <td>2</td>
						            <td>0</td>
						            <td>6.6k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/CollectedN">CollectedN</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>5.1k</td>
						          </tr>
						    </tbody>
						</table>
					</div>

					<div class="table-responsive contributorTable" id="table4" style="display: none;">
						<table class="table table-hover table-striped">
					        <thead>
					          	<th>&nbsp;</th>
					          	<th>Tweets</th>
					          	<th>RTs</th>
					          	<th>Followers</th>
					        </thead>
					        <tbody>					          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/thailand_jp">show only tweet</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>8.5k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/JBGOT7_Thailand">JBGOT7_Thailand</a></td>
						            <td>2</td>
						            <td>0</td>
						            <td>6.6k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/CollectedN">CollectedN</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>5.1k</td>
						          </tr>
						    </tbody>
						</table>
					</div>

					<div class="table-responsive contributorTable" id="table5" style="display: none;">
						<table class="table table-hover table-striped">
					        <thead>
					          	<th>&nbsp;</th>
					          	<th>Tweets</th>
					          	<th>RTs</th>
					          	<th>Followers</th>
					        </thead>
					        <tbody>					          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/thailand_jp">show tweet and reply</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>8.5k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/JBGOT7_Thailand">JBGOT7_Thailand</a></td>
						            <td>2</td>
						            <td>0</td>
						            <td>6.6k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/CollectedN">CollectedN</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>5.1k</td>
						          </tr>
						    </tbody>
						</table>
					</div>

					<div class="table-responsive contributorTable" id="table6" style="display: none;">
						<table class="table table-hover table-striped">
					        <thead>
					          	<th>&nbsp;</th>
					          	<th>Tweets</th>
					          	<th>RTs</th>
					          	<th>Followers</th>
					        </thead>
					        <tbody>					          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/thailand_jp">show tweet and retweet</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>8.5k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/JBGOT7_Thailand">JBGOT7_Thailand</a></td>
						            <td>2</td>
						            <td>0</td>
						            <td>6.6k</td>
						          </tr>
						          
						        <tr>
						            <td class="screen_name"><a href="http://twitter.com/CollectedN">CollectedN</a></td>
						            <td>1</td>
						            <td>0</td>
						            <td>5.1k</td>
						          </tr>
						    </tbody>
						</table>
					</div>

                    <div class="table-responsive contributorTable" id="table7">
    	
				        <table class="table table-hover table-striped">
					        <thead>
					          <th>&nbsp;</th>
					          <th>Tweets</th>
					          <th>RTs</th>
					          <th>Followers</th>
					        </thead>
					        <tbody>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/thailand_jp">thailand_jp</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>8.5k</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/JBGOT7_Thailand">JBGOT7_Thailand</a></td>
					            <td>2</td>
					            <td>0</td>
					            <td>6.6k</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/CollectedN">CollectedN</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>5.1k</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/weyoyeyo">weyoyeyo</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>2.8k</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/iTravel_Channel">iTravel_Channel</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>2.5k</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/MINO_THAILAND">MINO_THAILAND</a></td>
					            <td>4</td>
					            <td>0</td>
					            <td>2.3k</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/unctadwif">unctadwif</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>2k</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/NEY_Sulli94">NEY_Sulli94</a></td>
					            <td>4</td>
					            <td>0</td>
					            <td>628</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/9af0f531e5684db">9af0f531e5684db</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>603</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/ytrehcod">ytrehcod</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>557</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/PaPinn_z">PaPinn_z</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>490</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/JMinFa_BF">JMinFa_BF</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>484</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/asiapiamrak">asiapiamrak</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>441</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/JRMUKYOOK">JRMUKYOOK</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>381</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/pawind">pawind</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>370</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/aninafatini">aninafatini</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>313</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/pangram_felton">pangram_felton</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>312</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/Esterlify">Esterlify</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>267</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/YalindaL">YalindaL</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>255</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/theOther04">theOther04</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>252</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/ployypkt">ployypkt</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>251</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/NooLekMeePooH">NooLekMeePooH</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>238</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/xxludae">xxludae</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>219</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/viewrinrada">viewrinrada</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>197</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/bun_lucila">bun_lucila</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>153</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/Nnowzs">Nnowzs</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>149</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/Jomjam_XH">Jomjam_XH</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>143</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/Zhinzilla">Zhinzilla</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>139</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/LinneaLarsson16">LinneaLarsson16</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>132</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/curvesinth">curvesinth</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>124</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/KwanMasuda">KwanMasuda</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>121</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/aum_aomam">aum_aomam</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>89</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/goodn_ess">goodn_ess</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>86</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/thetravellers1">thetravellers1</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>85</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/noie_Ruk_bilarn">noie_Ruk_bilarn</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>77</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/Kameyamafuko">Kameyamafuko</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>74</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/NATT0830">NATT0830</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>70</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/ShearinPHR">ShearinPHR</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>36</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/44Melodyth">44Melodyth</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>15</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/be_sugarlove2">be_sugarlove2</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>14</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/chunchow2407">chunchow2407</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>1</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/ventique199">ventique199</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>1</td>
					          </tr>
					          
					        <tr>
					            <td class="screen_name"><a href="http://twitter.com/RBandhukiul">RBandhukiul</a></td>
					            <td>1</td>
					            <td>0</td>
					            <td>0</td>
					          </tr>
					          
					        </tbody>
					      </table>
		  			</div>
                </div>
            </div>
        </div>
	</div>
</div>

