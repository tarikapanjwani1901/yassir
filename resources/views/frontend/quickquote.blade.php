@include('frontend.header')
	<div id="main" class="inner-content  contact-page">
	   <div class="inner-banner-row" style="background-image:url(public/images/inner-banner1.png);">
	<div class="bannertext">
               <h1>Quick Quote</h1>
			    <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</span>
    </div>
	</div>  <div class="quick-quote-page">
	<div class="container padd100">
	    <div class="formttl text-center">
		   <table>
		      <tr>
			    <td class="text-right">
				  <img src="public/images/quote-icon.png">
				</td>
				<td class="text-left">
				   <h2>Request for Quotation</h2>
				   <p>Lorem Ipsum is simply dummy text of the printing and
typesetting industry.</p>
				</td>
			  </tr>
		   </table>
		</div>
	      <form>
		  <div class="formheader">
		  <div class="fromgroup">
		     <input type="text" placeholder="Enter the name1">
			 </div>
			 <div class="fromgroup selectrow">
			 <select>
			    <option>Please select a Category</option>
			 </select>
                 </div>
				 	 <div class="fromgroup">
					    <div class="row">
						   <div class="col-sm-6">	 <select>
			    <option>Please select a Category</option>
			 </select></div><div class="col-sm-6 selectrow">	 <select>
			    <option>Please select a Category</option>
			 </select>

			 </div>
						</div>
					 </div>
					 	 <div class="fromgroup">
					    <div class="row">
						   <div class="col-sm-6">	    
						   <input type="text" placeholder="Destination Port"></div><div class="col-sm-6">	 <select>
			    <option>Please select a Category</option>
			 </select></div>
						</div>
					 </div>
					 <p>Please let Us know your detailed requirements. You may include: color, size, material, grade/standard, etc</p>
					 <div class="fromgroup">
					  <textarea rows="5">Dear Sir/Madam,
I'm looking …….
					  </textarea>
					 </div>
					 	 <div class="fromgroup">
					 <h6>other Requiremnets</h6>
					 <div class="checkboxrow">
					    <div class="checkbox-box">
						   <input type="checkbox">
						   <label>Anonymous Proxy</label>
						</div>
											    <div class="checkbox-box">
						   <input type="checkbox">
						   <label>Anonymous Proxy</label>
						</div>					    <div class="checkbox-box">
						   <input type="checkbox">
						   <label>Anonymous Proxy</label>
						</div>
					 </div>
					 </div>
					 	 <div class="fromgroup imguploadrow">
						    <div class="imgupload">
							   <input type="file">
							  <i class="fa fa-picture-o" aria-hidden="true"></i> Upload Attachments


							</div>
						 </div>
			 </div>
			 <div class="formfooter">
			    <input type="submit" value="Submit your request">
			 </div>
		  </form>

		 </div>
	</div>
@include('frontend.footer')