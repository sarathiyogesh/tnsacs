<?php
    use App\Models\Customfieldsection;
    use App\Models\Customfield;
    use App\Models\Customfieldmeta;
?>
    <?php
        $section_list = Customfieldsection::where('user_id', Auth::id())->where('asset_master_id', $asset_master_id)->orderBy('id','ASC')->get();
    ?>
    @foreach($section_list as $list)
        <?php
            $sections = Customfield::where('custom_fields_section_id', $list->id)->where('user_id', Auth::id())->where('asset_master_id', $asset_master_id)->orderBy('sort_order','ASC')->get();
        ?>
        @if($template == 'no')
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">{!! $list->section_name !!}</div>
                        </div>
                    </div>
                    <form class="sectionForm_{{$list->id}}">
                        <div class="card-body">
                            @include('cms.customfield_preview_inner_template',['sections',$sections,'if_edit'=>'yes','template'=>$template])
                            <br>
                            <div class="row col-md-2 pull-right">
                                <a href="javascript:;" class="btn btn-sm btn-primary updateSectionContent" data-sec="{{ $list->id }}">Update</a>
                            </div>
                        </div>
                    </form>
                        
                    
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">{!! $list->section_name !!} &nbsp; <a href="javascript:;" class="removeSectionBtn" sec-id="{{encrypt($list->id)}}"><i class="fa fa-trash"></i></a></div>
                            <div class="col-md-4 text-right">
                                <a href="javascript:;" class="addCustomFieldBtn" data-txt="{!! $list->section_name !!}" sec-id="{{encrypt($list->id)}}"><i class="fas fa-user-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <form class="sectionForm_7">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                   <table class="table table-bordered">
                                        <thead>
                                           <tr>
                                               <th>Field name</th>
                                               <th>Type</th>
                                               <th>Actions</th>
                                           </tr>
                                        </thead>
                                       <tbody section_pos="{{ $list->id }}">
                                            @if(count($sections) > 0)
                                                @foreach($sections as $section)
                                                    <tr field_pos="{{ $section->id }}">
                                                       <td>{!! $section->label_name !!}</td>
                                                       <td>{!! $section->field_type !!}</td>
                                                       <td>
                                                            <a href="javascript:;" class="editField" field-id="{{ encrypt($section->id) }}"><i class="fa fa-edit"></i></a>
                                                            <a href="javascript:;" class="removeField" field-id="{{ encrypt($section->id) }}"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3">Fields not available</td>
                                                </tr>
                                            @endif
                                       </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                   </form>
                </div>
            </div>
        @endif
    @endforeach

