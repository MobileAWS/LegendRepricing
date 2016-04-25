<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
          <form onsubmit="javascript:return check('y','Y', 'y');" action="processTxn" method="post" class="appnitro" id="form_60556" name="CardDetailForm">
          <div id="left">
          <ul>
            <li id="li_1">
              <label for="li_1" class="description">Cardholder Name *</label>
              <div>
                <input value="" class="element text medium" maxlength="40" size="40" name="name" id="element_1_1">
                <label class="width400px pad" for="element_1_1">(as it appears on the card)</label>
              </div>
           	    </li>
            <li id="li_2" class="">
              <label for="li_2" class="description">Card Number * </label>
              <div>
                <input onkeyup="javascript:checkInput();" value="" class="element text medium" maxlength="19" size="19" name="pan" id="element_2_1">
                <label class="width400px pad" for="element_2_1">(enter without spaces)</label>
              </div>
            </li>
			
            <li style="width: 450px;" id="li_3">
              <label for="li_3" class="description pad5pxright">Expiry Date *</label>
              <div class="padleft" id="element_3_1"><font face="ARIAL" size="2" color="#0000cc">
                <select id="exmonth" name="edmm">
                
                  <option selected="selected"></option>
                  
                  <option value="01">01</option>
                  
                  <option value="02">02</option>
                  
                  <option value="03">03</option>
                  
                  <option value="04">04</option>
                  
                  <option value="05">05</option>
                  
                  <option value="06">06</option>
                  
                  <option value="07">07</option>
                  
                  <option value="08">08</option>
                  
                  <option value="09">09</option>
                  
                  <option value="10">10</option>
                  
                  <option value="11">11</option>
                  
                  <option value="12">12</option>
                  
                </select>
                </font> <font face="ARIAL" size="2" color="#0000cc"> <span class="left">
                <label for="exmonth">month</label>
                </span>
				
                <select style="float: left; width: auto;" id="exyear" name="edyy">
               
                  <option selected="selected"></option>
                  
                   <option value="2003">2003</option>
                  
                   <option value="2004">2004</option>
                  
                   <option value="2005">2005</option>
                  
                   <option value="2006">2006</option>
                  
                   <option value="2007">2007</option>
                  
                   <option value="2008">2008</option>
                  
                   <option value="2009">2009</option>
                  
                   <option value="2010">2010</option>
                  
                   <option value="2011">2011</option>
                  
                   <option value="2012">2012</option>
                  
                   <option value="2013">2013</option>
                  
                   <option value="2014">2014</option>
                  
                   <option value="2015">2015</option>
                  
                   <option value="2016">2016</option>
                  
                   <option value="2017">2017</option>
                  
                   <option value="2018">2018</option>
                  
                   <option value="2019">2019</option>
                  
                   <option value="2020">2020</option>
                  
                   <option value="2021">2021</option>
                  
                   <option value="2022">2022</option>
                  
                   <option value="2023">2023</option>
                  
                   <option value="2024">2024</option>
                  
                   <option value="2025">2025</option>
                  
                   <option value="2026">2026</option>
                  
                   <option value="2027">2027</option>
                  
                   <option value="2028">2028</option>
                  
                   <option value="2029">2029</option>
                  
                   <option value="2030">2030</option>
                  
                   <option value="2031">2031</option>
                  
                   <option value="2032">2032</option>
                  
                   <option value="2033">2033</option>
                  
                   <option value="2034">2034</option>
                  
                   <option value="2035">2035</option>
                  
                   <option value="2036">2036</option>
                  
                   <option value="2037">2037</option>
                  
                   <option value="2038">2038</option>
                  
                   <option value="2039">2039</option>
                  
                   <option value="2040">2040</option>
                  
                   <option value="2041">2041</option>
                  
                   <option value="2042">2042</option>
                  
                   <option value="2043">2043</option>
                  
                   <option value="2044">2044</option>
                  
                   <option value="2045">2045</option>
                  
                   <option value="2046">2046</option>
                  
                   <option value="2047">2047</option>
                  
                   <option value="2048">2048</option>
                  
                   <option value="2049">2049</option>
                  
                   <option value="2050">2050</option>
                  
                   <option value="2051">2051</option>
                  
                   <option value="2052">2052</option>
                  
                   <option value="2053">2053</option>
                  
                   <option value="2054">2054</option>
                  
                   <option value="2055">2055</option>
                  
                   <option value="2056">2056</option>
                  
                   <option value="2057">2057</option>
                  
                   <option value="2058">2058</option>
                  
                   <option value="2059">2059</option>
                  
                   <option value="2060">2060</option>
                  
                   <option value="2061">2061</option>
                  

                </select>
                <span class="left">
                <label style="float: left;" for="exyear">year</label>
                </span></font>
                <label class="width400px pad120px" for="element_3_1">(as it appears on the card)</label>
                </div>
                
            </li>
            <li style="width: 450px;" id="li_4">
              <label for="li_4" class="description pad5pxright">Start Date</label>
              <div class="padleft" id="element_4_1"><font face="ARIAL" size="2" color="#0000cc">
                <select id="stmonth" name="sdmm">

                    <option selected="selected"></option>
                 
				
                  <option value="01">01</option>
                  
                  <option value="02">02</option>
                  
                  <option value="03">03</option>
                  
                  <option value="04">04</option>
                  
                  <option value="05">05</option>
                  
                  <option value="06">06</option>
                  
                  <option value="07">07</option>
                  
                  <option value="08">08</option>
                  
                  <option value="09">09</option>
                  
                  <option value="10">10</option>
                  
                  <option value="11">11</option>
                  
                  <option value="12">12</option>
                  
                 
                </select>
                </font> <font face="ARIAL" size="2" color="#0000cc"> <span class="left">
                <label for="stmonth">month</label>
                </span>
                <select style="float: left; width: auto;" id="styear" name="sdyy">

                    <option selected="selected"></option>
                  
                 <option value="1996">1996</option>
                  
                 <option value="1997">1997</option>
                  
                 <option value="1998">1998</option>
                  
                 <option value="1999">1999</option>
                  
                 <option value="2000">2000</option>
                  
                 <option value="2001">2001</option>
                  
                 <option value="2002">2002</option>
                  
                 <option value="2003">2003</option>
                  
                 <option value="2004">2004</option>
                  
                 <option value="2005">2005</option>
                  
                 <option value="2006">2006</option>
                  
                 <option value="2007">2007</option>
                  
                 <option value="2008">2008</option>
                  
                 <option value="2009">2009</option>
                  
                 <option value="2010">2010</option>
                  
                 <option value="2011">2011</option>
                  
                 <option value="2012">2012</option>
                  
                 <option value="2013">2013</option>
                  
                 <option value="2014">2014</option>
                  
                 <option value="2015">2015</option>
                  
                 <option value="2016">2016</option>
                  
                 <option value="2017">2017</option>
                  
                 <option value="2018">2018</option>
                  
                 <option value="2019">2019</option>
                  
                 <option value="2020">2020</option>
                  
                 <option value="2021">2021</option>
                  
                 <option value="2022">2022</option>
                  
                 <option value="2023">2023</option>
                  
                 <option value="2024">2024</option>
                  
                 <option value="2025">2025</option>
                  
                 <option value="2026">2026</option>
                  
                 <option value="2027">2027</option>
                  
                 <option value="2028">2028</option>
                  
                 <option value="2029">2029</option>
                  
                 <option value="2030">2030</option>
                  
                 <option value="2031">2031</option>
                  
                 <option value="2032">2032</option>
                  
                 <option value="2033">2033</option>
                  
                 <option value="2034">2034</option>
                  
                 <option value="2035">2035</option>
                  
                 <option value="2036">2036</option>
                  
                 <option value="2037">2037</option>
                  
                 <option value="2038">2038</option>
                  
                 <option value="2039">2039</option>
                  
                 <option value="2040">2040</option>
                  
                 <option value="2041">2041</option>
                  
                 <option value="2042">2042</option>
                  
                 <option value="2043">2043</option>
                  
                 <option value="2044">2044</option>
                  
                 <option value="2045">2045</option>
                  
                 <option value="2046">2046</option>
                  
                 <option value="2047">2047</option>
                  
                 <option value="2048">2048</option>
                  
                 <option value="2049">2049</option>
                  
                 <option value="2050">2050</option>
                  
                 <option value="2051">2051</option>
                  
                 <option value="2052">2052</option>
                  
                 <option value="2053">2053</option>
                  
                 <option value="2054">2054</option>
                  
                 <option value="2055">2055</option>
                  
                 <option value="2056">2056</option>
                  
                 <option value="2057">2057</option>
                  
                 <option value="2058">2058</option>
                  
                 <option value="2059">2059</option>
                  
                 <option value="2060">2060</option>
                  
                 <option value="2061">2061</option>
                  
                </select>
                <span class="left">
                <label style="float: left;" for="styear">year</label>
                </span></font>
                <label class="width400px pad120px" for="element_4_1">(if not present, leave blank)</label>
                </div>
                
            </li>
			<li id="li_5">
              <!--<label class="description" for="li_5">Security Code * </label> -->
              <label for="li_5" class="description">Security Code </label>
              <div>
                <input type="text" style="float: left; width: 50px;" value="" maxlength="4" size="4" class="element text" name="cvv" id="element_5_1">  <a style="float: left; width: 100px; margin-top: 4px; margin-left: 5px;" href="Help.jsp"> (<i class="fontsize">What's This</i>)</a>
                <label class="width400px pad" for="element_5_1">(3 or 4 digits security code)</label>
              </div>
            </li>
			
            <li id="li_6" class="">
              <label for="li_6" class="description">Issue Number </label>
              <div>
                <input onkeyup="javascript:checkInputForIssueNumber();" maxlength="2" class="element text medium" value="" size="20" name="issueno" id="element_6_1">
                <label class="width400px pad" for="element_6_1">(if not present, leave blank)</label>
              </div>
            </li>
            
            <li id="li_7">
              <label for="li_7" class="description">Address *</label>
              <div>
                <input class="element text medium" value="" maxlength="30" size="20" name="ad1" id="element_7_1">
             <!--   <label for="element_7_1" class="width400px" style="padding-left:130px;">Street Address *</label>-->
              </div>
			  </li>
			  <li id="li_71">
			   <label class="description" for="element_7_2">Address Line 2 </label>
              <div>
                <input class="element text medium" value="" maxlength="30" size="20" name="ad2" id="element_7_2">
              </div>
              </li>
			  <li id="li_72">
			    <label class="description" for="element_7_3">City *</label>
			  <div>
                <input class="element text medium" value="" maxlength="30" size="20" name="city" id="element_7_3">
              </div>
              </li>
			  <li id="li_73">
			  <label class="description" for="element_7_4">State / Province / Region </label>
			  <div>
                <input type="text" maxlength="20" size="20" value="" class="element text medium" name="state" id="element_7_4">
                
              </div>
              </li>
			  <li id="li_74">
			 <label class="description" for="element_7_5">Postal / Zip Code *</label>
			  <div>
			    <input value="" class="element text medium" maxlength="10" size="7" name="postCode" id="element_7_5">
              </div>
              </li>
			  <li id="li_75" class="">
			   <label class="description pad5pxright" for="element_7_6">Country *</label>
			  <div style="padding-left: 10px;">
                <select name="countries" id="element_7_6" style="width: 180px;" class="element select medium">
                
                  <option selected="selected"></option>
                  

                  

                  <option value="AF">AFGHANISTAN                                       </option>
                  

                  <option value="AL">ALBANIA                                           </option>
                  

                  <option value="DZ">ALGERIA                                           </option>
                  

                  <option value="AS">AMERICAN SAMOA                                    </option>
                  

                  <option value="AD">ANDORRA                                           </option>
                  

                  <option value="AO">ANGOLA                                            </option>
                  

                  <option value="AI">ANGUILLA                                          </option>
                  

                  <option value="AQ">ANTARCTICA                                        </option>
                  

                  <option value="AG">ANTIGUA AND BARBUDA                               </option>
                  

                  <option value="AR">ARGENTINA                                         </option>
                  

                  <option value="AM">ARMENIA                                           </option>
                  

                  <option value="AW">ARUBA                                             </option>
                  

                  <option value="AU">AUSTRALIA                                         </option>
                  

                  <option value="AT">AUSTRIA                                           </option>
                  

                  <option value="AZ">AZERBAIJAN                                        </option>
                  

                  <option value="BS">BAHAMAS                                           </option>
                  

                  <option value="BH">BAHRAIN                                           </option>
                  

                  <option value="BD">BANGLADESH                                        </option>
                  

                  <option value="BB">BARBADOS                                          </option>
                  

                  <option value="BY">BELARUS                                           </option>
                  

                  <option value="BE">BELGIUM                                           </option>
                  

                  <option value="BZ">BELIZE                                            </option>
                  

                  <option value="BJ">BENIN                                             </option>
                  

                  <option value="BM">BERMUDA                                           </option>
                  

                  <option value="BT">BHUTAN                                            </option>
                  

                  <option value="BO">BOLIVIA                                           </option>
                  

                  <option value="BA">BOSNIA AND HERZEGOWINA                            </option>
                  

                  <option value="BW">BOTSWANA                                          </option>
                  

                  <option value="BV">BOUVET ISLAND                                     </option>
                  

                  <option value="BR">BRAZIL                                            </option>
                  

                  <option value="IO">BRITISH INDIAN OCEAN TERRITORY                    </option>
                  

                  <option value="BN">BRUNEI DARUSSALAM                                 </option>
                  

                  <option value="BG">BULGARIA                                          </option>
                  

                  <option value="BF">BURKINA FASO                                      </option>
                  

                  <option value="BI">BURUNDI                                           </option>
                  

                  <option value="KH">CAMBODIA                                          </option>
                  

                  <option value="CM">CAMEROON                                          </option>
                  

                  <option value="CA">CANADA                                            </option>
                  

                  <option value="CV">CAPE VERDE                                        </option>
                  

                  <option value="KY">CAYMAN ISLANDS                                    </option>
                  

                  <option value="CF">CENTRAL AFRICAN REPUBLIC                          </option>
                  

                  <option value="TD">CHAD                                              </option>
                  

                  <option value="CL">CHILE                                             </option>
                  

                  <option value="CN">CHINA                                             </option>
                  

                  <option value="CX">CHRISTMAS ISLAND                                  </option>
                  

                  <option value="CC">COCOS (KEELING) ISLANDS                           </option>
                  

                  <option value="CO">COLOMBIA                                          </option>
                  

                  <option value="KM">COMOROS                                           </option>
                  

                  <option value="CD">CONGO, Democratic Republic of (was Zaire)         </option>
                  

                  <option value="CG">CONGO, People s Republic of                       </option>
                  

                  <option value="CK">COOK ISLANDS                                      </option>
                  

                  <option value="CR">COSTA RICA                                        </option>
                  

                  <option value="CI">COTE DIVOIRE                                      </option>
                  

                  <option value="HR">CROATIA (local name: Hrvatska)                    </option>
                  

                  <option value="CU">CUBA                                              </option>
                  

                  <option value="CY">CYPRUS                                            </option>
                  

                  <option value="CZ">CZECH REPUBLIC                                    </option>
                  

                  <option value="DK">DENMARK                                           </option>
                  

                  <option value="DJ">DJIBOUTI                                          </option>
                  

                  <option value="DM">DOMINICA                                          </option>
                  

                  <option value="DO">DOMINICAN REPUBLIC                                </option>
                  

                  <option value="TL">EAST TIMOR                                        </option>
                  

                  <option value="EC">ECUADOR                                           </option>
                  

                  <option value="EG">EGYPT                                             </option>
                  

                  <option value="SV">EL SALVADOR                                       </option>
                  

                  <option value="GQ">EQUATORIAL GUINEA                                 </option>
                  

                  <option value="ER">ERITREA                                           </option>
                  

                  <option value="EE">ESTONIA                                           </option>
                  

                  <option value="ET">ETHIOPIA                                          </option>
                  

                  <option value="FK">FALKLAND ISLANDS (MALVINAS)                       </option>
                  

                  <option value="FO">FAROE ISLANDS                                     </option>
                  

                  <option value="FJ">FIJI                                              </option>
                  

                  <option value="FI">FINLAND                                           </option>
                  

                  <option value="FR">FRANCE                                            </option>
                  

                  <option value="FX">FRANCE, METROPOLITAN                              </option>
                  

                  <option value="GF">FRENCH GUIANA                                     </option>
                  

                  <option value="PF">FRENCH POLYNESIA                                  </option>
                  

                  <option value="TF">FRENCH SOUTHERN TERRITORIES                       </option>
                  

                  <option value="GA">GABON                                             </option>
                  

                  <option value="GM">GAMBIA                                            </option>
                  

                  <option value="GE">GEORGIA                                           </option>
                  

                  <option value="DE">GERMANY                                           </option>
                  

                  <option value="GH">GHANA                                             </option>
                  

                  <option value="GI">GIBRALTAR                                         </option>
                  

                  <option value="GR">GREECE                                            </option>
                  

                  <option value="GL">GREENLAND                                         </option>
                  

                  <option value="GD">GRENADA                                           </option>
                  

                  <option value="GP">GUADELOUPE                                        </option>
                  

                  <option value="GU">GUAM                                              </option>
                  

                  <option value="GT">GUATEMALA                                         </option>
                  

                  <option value="GN">GUINEA                                            </option>
                  

                  <option value="GW">GUINEA-BISSAU                                     </option>
                  

                  <option value="GY">GUYANA                                            </option>
                  

                  <option value="HT">HAITI                                             </option>
                  

                  <option value="HM">HEARD AND MC DONALD ISLANDS                       </option>
                  

                  <option value="HN">HONDURAS                                          </option>
                  

                  <option value="HK">HONG KONG                                         </option>
                  

                  <option value="HU">HUNGARY                                           </option>
                  

                  <option value="IS">ICELAND                                           </option>
                  

                  <option value="IN">INDIA                                             </option>
                  

                  <option value="ID">INDONESIA                                         </option>
                  

                  <option value="IR">IRAN (ISLAMIC REPUBLIC OF)                        </option>
                  

                  <option value="IQ">IRAQ                                              </option>
                  

                  <option value="IE">IRELAND                                           </option>
                  

                  <option value="IL">ISRAEL                                            </option>
                  

                  <option value="IT">ITALY                                             </option>
                  

                  <option value="JM">JAMAICA                                           </option>
                  

                  <option value="JP">JAPAN                                             </option>
                  

                  <option value="JO">JORDAN                                            </option>
                  

                  <option value="KZ">KAZAKHSTAN                                        </option>
                  

                  <option value="KE">KENYA                                             </option>
                  

                  <option value="KI">KIRIBATI                                          </option>
                  

                  <option value="KP">KOREA, DEMOCRATIC PEOPLE S REPUBLIC OF            </option>
                  

                  <option value="KR">KOREA, REPUBLIC OF                                </option>
                  

                  <option value="KW">KUWAIT                                            </option>
                  

                  <option value="KG">KYRGYZSTAN                                        </option>
                  

                  <option value="LA">LAO PEOPLE S DEMOCRATIC REPUBLIC                  </option>
                  

                  <option value="LV">LATVIA                                            </option>
                  

                  <option value="LB">LEBANON                                           </option>
                  

                  <option value="LS">LESOTHO                                           </option>
                  

                  <option value="LR">LIBERIA                                           </option>
                  

                  <option value="LY">LIBYAN ARAB JAMAHIRIYA                            </option>
                  

                  <option value="LI">LIECHTENSTEIN                                     </option>
                  

                  <option value="LT">LITHUANIA                                         </option>
                  

                  <option value="LU">LUXEMBOURG                                        </option>
                  

                  <option value="MO">MACAU                                             </option>
                  

                  <option value="MK">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF        </option>
                  

                  <option value="MG">MADAGASCAR                                        </option>
                  

                  <option value="MW">MALAWI                                            </option>
                  

                  <option value="MY">MALAYSIA                                          </option>
                  

                  <option value="MV">MALDIVES                                          </option>
                  

                  <option value="ML">MALI                                              </option>
                  

                  <option value="MT">MALTA                                             </option>
                  

                  <option value="MH">MARSHALL ISLANDS                                  </option>
                  

                  <option value="MQ">MARTINIQUE                                        </option>
                  

                  <option value="MR">MAURITANIA                                        </option>
                  

                  <option value="MU">MAURITIUS                                         </option>
                  

                  <option value="YT">MAYOTTE                                           </option>
                  

                  <option value="MX">MEXICO                                            </option>
                  

                  <option value="FM">MICRONESIA, FEDERATED STATES OF                   </option>
                  

                  <option value="MD">MOLDOVA, REPUBLIC OF                              </option>
                  

                  <option value="MC">MONACO                                            </option>
                  

                  <option value="MN">MONGOLIA                                          </option>
                  

                  <option value="MS">MONTSERRAT                                        </option>
                  

                  <option value="MA">MOROCCO                                           </option>
                  

                  <option value="MZ">MOZAMBIQUE                                        </option>
                  

                  <option value="MM">MYANMAR                                           </option>
                  

                  <option value="NA">NAMIBIA                                           </option>
                  

                  <option value="NR">NAURU                                             </option>
                  

                  <option value="NP">NEPAL                                             </option>
                  

                  <option value="NL">NETHERLANDS                                       </option>
                  

                  <option value="AN">NETHERLANDS ANTILLES                              </option>
                  

                  <option value="NC">NEW CALEDONIA                                     </option>
                  

                  <option value="NZ">NEW ZEALAND                                       </option>
                  

                  <option value="NI">NICARAGUA                                         </option>
                  

                  <option value="NE">NIGER                                             </option>
                  

                  <option value="NG">NIGERIA                                           </option>
                  

                  <option value="NU">NIUE                                              </option>
                  

                  <option value="NF">NORFOLK ISLAND                                    </option>
                  

                  <option value="MP">NORTHERN MARIANA ISLANDS                          </option>
                  

                  <option value="NO">NORWAY                                            </option>
                  

                  <option value="OM">OMAN                                              </option>
                  

                  <option value="PK">PAKISTAN                                          </option>
                  

                  <option value="PW">PALAU                                             </option>
                  

                  <option value="PS">PALESTINIAN TERRITORY, Occupied                   </option>
                  

                  <option value="PA">PANAMA                                            </option>
                  

                  <option value="PG">PAPUA NEW GUINEA                                  </option>
                  

                  <option value="PY">PARAGUAY                                          </option>
                  

                  <option value="PE">PERU                                              </option>
                  

                  <option value="PH">PHILIPPINES                                       </option>
                  

                  <option value="PN">PITCAIRN                                          </option>
                  

                  <option value="PL">POLAND                                            </option>
                  

                  <option value="PT">PORTUGAL                                          </option>
                  

                  <option value="PR">PUERTO RICO                                       </option>
                  

                  <option value="QA">QATAR                                             </option>
                  

                  <option value="RE">REUNION                                           </option>
                  

                  <option value="RO">ROMANIA                                           </option>
                  

                  <option value="RU">RUSSIAN FEDERATION                                </option>
                  

                  <option value="RW">RWANDA                                            </option>
                  

                  <option value="KN">SAINT KITTS AND NEVIS                             </option>
                  

                  <option value="LC">SAINT LUCIA                                       </option>
                  

                  <option value="VC">SAINT VINCENT AND THE GRENADINES                  </option>
                  

                  <option value="WS">SAMOA                                             </option>
                  

                  <option value="SM">SAN MARINO                                        </option>
                  

                  <option value="ST">SAO TOME AND PRINCIPE                             </option>
                  

                  <option value="SA">SAUDI ARABIA                                      </option>
                  

                  <option value="SN">SENEGAL                                           </option>
                  

                  <option value="SC">SEYCHELLES                                        </option>
                  

                  <option value="SL">SIERRA LEONE                                      </option>
                  

                  <option value="SG">SINGAPORE                                         </option>
                  

                  <option value="SK">SLOVAKIA (Slovak Republic)                        </option>
                  

                  <option value="SI">SLOVENIA                                          </option>
                  

                  <option value="SB">SOLOMON ISLANDS                                   </option>
                  

                  <option value="SO">SOMALIA                                           </option>
                  

                  <option value="ZA">SOUTH AFRICA                                      </option>
                  

                  <option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS      </option>
                  

                  <option value="ES">SPAIN                                             </option>
                  

                  <option value="LK">SRI LANKA                                         </option>
                  

                  <option value="SH">ST. HELENA                                        </option>
                  

                  <option value="PM">ST. PIERRE AND MIQUELON                           </option>
                  

                  <option value="SD">SUDAN                                             </option>
                  

                  <option value="SR">SURINAME                                          </option>
                  

                  <option value="SJ">SVALBARD AND JAN MAYEN ISLANDS                    </option>
                  

                  <option value="SZ">SWAZILAND                                         </option>
                  

                  <option value="SE">SWEDEN                                            </option>
                  

                  <option value="CH">SWITZERLAND                                       </option>
                  

                  <option value="SY">SYRIAN ARAB REPUBLIC                              </option>
                  

                  <option value="TW">TAIWAN                                            </option>
                  

                  <option value="TJ">TAJIKISTAN                                        </option>
                  

                  <option value="TZ">TANZANIA, UNITED REPUBLIC OF                      </option>
                  

                  <option value="TH">THAILAND                                          </option>
                  

                  <option value="TG">TOGO                                              </option>
                  

                  <option value="TK">TOKELAU                                           </option>
                  

                  <option value="TO">TONGA                                             </option>
                  

                  <option value="TT">TRINIDAD AND TOBAGO                               </option>
                  

                  <option value="TN">TUNISIA                                           </option>
                  

                  <option value="TR">TURKEY                                            </option>
                  

                  <option value="TM">TURKMENISTAN                                      </option>
                  

                  <option value="TC">TURKS AND CAICOS ISLANDS                          </option>
                  

                  <option value="TV">TUVALU                                            </option>
                  

                  <option value="UG">UGANDA                                            </option>
                  

                  <option value="UA">UKRAINE                                           </option>
                  

                  <option value="AE">UNITED ARAB EMIRATES                              </option>
                  

                  <option value="GB">UNITED KINGDOM                                    </option>
                  

                  <option value="US">UNITED STATES                                     </option>
                  

                  <option value="UM">UNITED STATES MINOR OUTLYING ISLANDS              </option>
                  

                  <option value="UY">URUGUAY                                           </option>
                  

                  <option value="UZ">UZBEKISTAN                                        </option>
                  

                  <option value="VU">VANUATU                                           </option>
                  

                  <option value="VA">VATICAN CITY STATE (HOLY SEE)                     </option>
                  

                  <option value="VE">VENEZUELA                                         </option>
                  

                  <option value="VN">VIET NAM                                          </option>
                  

                  <option value="VG">VIRGIN ISLANDS (BRITISH)                          </option>
                  

                  <option value="VI">VIRGIN ISLANDS (U.S.)                             </option>
                  

                  <option value="WF">WALLIS AND FUTUNA ISLANDS                         </option>
                  

                  <option value="EH">WESTERN SAHARA                                    </option>
                  

                  <option value="YE">YEMEN                                             </option>
                  

                  <option value="YU">YUGOSLAVIA                                        </option>
                  

                  <option value="ZM">ZAMBIA                                            </option>
                  

                  <option value="ZW">ZIMBABWE                                          </option>
                  
                  
                </select>
               </div>
            </li>
            <li id="li_8">
              <label for="li_8" class="description">Phone </label>
              <div>
              <input type="text" onkeyup="javascript:checkInputForPnoneNumber();" value="" maxlength="14" size="14" class="element text medium" name="phoneNumber" id="element_8_1">
              </div></li>
              
            <li id="li_9">
              <label for="li_9" class="description">Email Address</label>
              <div>
                <input value="" class="element text medium" maxlength="40" size="40" name="emailId">
              </div>
            </li>
			<li id="li_10">
              <label for="li_10" class="description">Confirm Email Address</label>
              <div>
                <input value="" class="element text medium" maxlength="40" size="40" name="emailIdConfirmation">
              </div>
            </li>
            <li class="buttons">
              <input type="submit" name="Submit" value="Pay">  
              <!--input type="button" value="Cancel" name="cancel" onclick="javascript:history.back();" /-->
              <input type="button" onclick="JAVASCRIPT:window.location.replace('Response.jsp?message=Transaction Cancel')" name="cancel" value="Cancel">
            </li>
			
          </ul>
        </div>
        </form>
</body>
</html>