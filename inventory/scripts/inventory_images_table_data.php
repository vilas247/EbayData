<div class="tab-pane">
   <div>
      <div>
         <div class="row">
            <div class="row">
               <div class="col-lg-12 market-tabs traditional" id="picksheet-tabs" style="margin: 20px 30px !important; width: 94.5% !important">
                  <div class="panel-body" id="product-category-pop">
                     <div type="pills" class="ng-isolate-scope">
                        <ul class="nav nav-pills" ng-class="{'nav-stacked': vertical, 'nav-justified': justified}" ng-transclude="">
                           <li ng-class="{active: active, disabled: disabled}" heading="Folderwise Images" class="media-martab-left-0 media-mar-left-0 ng-isolate-scope active">
                              <a href="" ng-click="select()" uib-tab-heading-transclude="" class="ng-binding">Folderwise Images</a>
                           </li>
                        </ul>
                        <div class="tab-content">
                           <!-- ngRepeat: tab in tabs -->
                           <div class="tab-pane ng-scope active" ng-repeat="tab in tabs" ng-class="{active: tab.active}" uib-tab-content-transclude="tab">
                              <div class="mar-bottom-30 ng-scope">
                                 <p class="pad-10 mar-left-30"> <strong class="ng-binding">57 images found</strong> </p>
                                 <div class="row col-lg-12">
                                    <div paging="" page="imgpageNumber" page-size="imgpageCount" total="imgtotalCount" adjacent="1" paging-action="viewimagepage('epos', page)" class="pull-right ng-isolate-scope">
                                       <ul data-ng-hide="Hide" data-ng-class="ulClass" class="pagination">
                                          <!-- ngRepeat: Item in List -->
                                          <li title="Page 1" data-ng-class="Item.liClass" data-ng-repeat="Item in List" class="ng-scope active" style=""> <a href="" data-ng-class="Item.aClass" data-ng-click="Item.action()" data-ng-bind="Item.value" class="ng-binding">1</a> </li>
                                          <!-- end ngRepeat: Item in List -->
                                          <li title="Page 2" data-ng-class="Item.liClass" data-ng-repeat="Item in List" class="ng-scope" style=""> <a href="" data-ng-class="Item.aClass" data-ng-click="Item.action()" data-ng-bind="Item.value" class="ng-binding">2</a> </li>
                                          <!-- end ngRepeat: Item in List -->
                                          <li title="Page 3" data-ng-class="Item.liClass" data-ng-repeat="Item in List" class="ng-scope"> <a href="" data-ng-class="Item.aClass" data-ng-click="Item.action()" data-ng-bind="Item.value" class="ng-binding">3</a> </li>
                                          <!-- end ngRepeat: Item in List -->
                                          <li title="Page 4" data-ng-class="Item.liClass" data-ng-repeat="Item in List" class="ng-scope"> <a href="" data-ng-class="Item.aClass" data-ng-click="Item.action()" data-ng-bind="Item.value" class="ng-binding">4</a> </li>
                                          <!-- end ngRepeat: Item in List -->
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="row mar-top-30 drop-and-drag-image">
                                    <!-- ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope" style="">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v1.jpg" id="img_0" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v1.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5036905442442v1.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v2.jpg" id="img_1" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v2.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5036905442442v2.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v3.jpg" id="img_2" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v3.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5036905442442v3.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v4.jpg" id="img_3" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v4.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5036905442442v4.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) -->
                                       <div ng-if="($index%4==0)  &amp;&amp; ($index!=0)" class="row col-sm-12 ng-scope"></div>
                                       <!-- end ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900121sfpv1.jpg" id="img_4" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900121sfpv1.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900121sfpv1.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900121sfpv2.jpg" id="img_5" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900121sfpv2.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900121sfpv2.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900121sfpv3.jpg" id="img_6" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900121sfpv3.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900121sfpv3.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900121sfpv4.jpg" id="img_7" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900121sfpv4.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900121sfpv4.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) -->
                                       <div ng-if="($index%4==0)  &amp;&amp; ($index!=0)" class="row col-sm-12 ng-scope"></div>
                                       <!-- end ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900138sfpv1.jpg" id="img_8" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900138sfpv1.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900138sfpv1.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900138sfpv2.jpg" id="img_9" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900138sfpv2.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900138sfpv2.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900138sfpv3.jpg" id="img_10" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900138sfpv3.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900138sfpv3.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900145sfpv1.jpg" id="img_11" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900145sfpv1.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900145sfpv1.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) -->
                                       <div ng-if="($index%4==0)  &amp;&amp; ($index!=0)" class="row col-sm-12 ng-scope"></div>
                                       <!-- end ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900145sfpv2.jpg" id="img_12" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900145sfpv2.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900145sfpv2.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900152sfpv1.jpg" id="img_13" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900152sfpv1.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900152sfpv1.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900152sfpv2.jpg" id="img_14" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900152sfpv2.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900152sfpv2.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 -->
                                    <div ng-repeat="image in list2" class="ng-scope">
                                       <!-- ngIf: ($index%4==0)  && ($index!=0) --> 
                                       <div class="col-md-3 text-center">
                                          <img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900152sfpv3.jpg" id="img_15" ng-click="imgdetails(image.url,'img_'+$index)" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5060622900152sfpv3.jpg">   <button type="button" ng-click="isChangeimage(image.imgname)" class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top"> <span class="fa fa-trash fa-lg"></span> </button> <button type="button" ng-click="EditImageOnline(image.url,'img_'+$index)" class="btn btn-xs invimg_btn" style="margin-top: -110px;margin-left: -39px"> <span class="fa fa-edit fa-lg"></span> </button> 
                                          <p class="mar-top-5 invimg_p"> <strong class="ng-binding">5060622900152sfpv3.jpg </strong> </p>
                                       </div>
                                    </div>
                                    <!-- end ngRepeat: image in list2 --> 
                                 </div>
                                 <div class="row col-lg-12">
                                    <div paging="" page="imgpageNumber" page-size="imgpageCount" total="imgtotalCount" adjacent="1" paging-action="viewimagepage('epos', page)" class="pull-right ng-isolate-scope">
                                       <ul data-ng-hide="Hide" data-ng-class="ulClass" class="pagination">
                                          <!-- ngRepeat: Item in List -->
                                          <li title="Page 1" data-ng-class="Item.liClass" data-ng-repeat="Item in List" class="ng-scope active" style=""> <a href="" data-ng-class="Item.aClass" data-ng-click="Item.action()" data-ng-bind="Item.value" class="ng-binding">1</a> </li>
                                          <!-- end ngRepeat: Item in List -->
                                          <li title="Page 2" data-ng-class="Item.liClass" data-ng-repeat="Item in List" class="ng-scope" style=""> <a href="" data-ng-class="Item.aClass" data-ng-click="Item.action()" data-ng-bind="Item.value" class="ng-binding">2</a> </li>
                                          <!-- end ngRepeat: Item in List -->
                                          <li title="Page 3" data-ng-class="Item.liClass" data-ng-repeat="Item in List" class="ng-scope"> <a href="" data-ng-class="Item.aClass" data-ng-click="Item.action()" data-ng-bind="Item.value" class="ng-binding">3</a> </li>
                                          <!-- end ngRepeat: Item in List -->
                                          <li title="Page 4" data-ng-class="Item.liClass" data-ng-repeat="Item in List" class="ng-scope"> <a href="" data-ng-class="Item.aClass" data-ng-click="Item.action()" data-ng-bind="Item.value" class="ng-binding">4</a> </li>
                                          <!-- end ngRepeat: Item in List -->
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- end ngRepeat: tab in tabs -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end ngIf: tab.active==true --> 
</div>