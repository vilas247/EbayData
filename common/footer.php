			<footer style="background-color: #1f1f1f" >
              <div class="row login-footer ng-scope">
                <div class="col-md-3 text-left"> <span class="pad-left-20">Contact:&nbsp;<a href="https://showcase.247cloudhub.co.uk/#">support@247cloudhub.co.uk</a></span> </div>
                <div class="col-md-6 text-center"> <span>©</span> <span >2011 - 2019 247 Commerce Limited.</span> <span >All Rights Reserved.</span> <span> 247 Cloudhub is a registered trademark of <a href="http://www.247commerce.co.uk/" tabindex="9" target="_blank">247Commerce.</a> <a href="https://showcase.247cloudhub.co.uk/#/app/privacy-policy" tabindex="10" style="margin-left:10px" target="_blank">Privacy Policy</a><a href="https://showcase.247cloudhub.co.uk/#/app/terms-of-use" tabindex="11" style="margin-left:10px" target="_blank">Terms of Use</a></span>  </div>
                <div class="col-md-3 text-right"> <span class="pad-right-20">Licensed to: 247 Commerce Ltd</span> </div>
              </div>
              <script class="ng-scope">(function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function ()
                { (i[r].q = i[r].q || []).push(arguments) }
                
                , i[r].l = 1 * new Date(); a = s.createElement(o),
                m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
                
                ga('create', 'UA-69432614-1', 'auto');
                //ga('send', 'pageview');
              </script>
          </footer>

		</div> <!-- ./<div style="height:fit-content"> -->
	</div> <!-- ./<div class="wrapper" style=""> -->
</body>
<script type="text/javascript">
		$(function () {
			function loadVendors(){
				$.ajax({
					type: 'GET',
					url: app_base_url + 'common/getAllVendors.php',
					async: true,
					cache: true,
					dataType: 'json',
					success: function (res) {
						if (res.status) {
							var data = res.data;
							var databases = data.databases;
							var vendorcode = '';
							var dbcode = "<?= $_SESSION['dbcode'] ?>"
							$.each( databases, function( key, val ) {
								var selected = '';
								if(dbcode == val.dbcode){
									selected = "selected";
								}
								vendorcode += "<option "+selected+" value="+val.dbcode+">"+val.dbname+" - "+val.companyname+"</option>";
							});
							$('#vendorcode').html(vendorcode);
						}
					}
				});
			}
			loadVendors();
		});
		/*Switch dbcode */
		$('body').on("submit",'#switchDbcode',function( e) {
			e.preventDefault();
			$('#myModal').modal('hide');
			$('.traditional').addClass('whirl');
			$.ajax({
				type: 'POST',
				url: app_base_url + 'common/switchDbcode.php',
				async: true,
				cache: true,
				data: $('#switchDbcode').serializeArray(),
				dataType: 'json',
				success: function (res) {
					var url = '<?= SWITCH_DB_CODE ?>'+'switchvendor?dbcode='+$('#vendorcode').val();
					var element = document.createElement("iframe"); 
					element.setAttribute('src', url);
					element.setAttribute('style', "display:none");
					document.body.appendChild(element);
					setTimeout(function(){
						window.location = "<?= SWITCH_DB_CODE."dashboard" ?>";
					},10000);
					//getClose();
				}
			});
		});
		$('body').on('click','#editAccount',function(){
			var eId = btoa("usercode#<?= $_SESSION['usercode'] ?>#247cloudhubencrypted");
			window.location.href = "<?= SWITCH_DB_CODE ?>edit-user/" + eId;
		})
</script>

</html>