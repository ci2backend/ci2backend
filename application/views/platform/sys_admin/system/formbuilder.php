<div class="row clearfix">

    <div class="grid_6 col-lg-6">
        <div class="clearfix">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Your Form</h3>
                </div>
                <div class="panel-body">
                    <div id="build">
                        <form id="target" class="form-horizontal">
                            <fieldset>
                                <div id="legend" class="component" rel="popover" title="Form Title" trigger="manual" data-content="
                        <form class='form'>
                          <div class='form-group col-md-12'>
                            <label class='control-label'>Title</label> <input class='form-control' type='text' name='title' id='text'>
                            <hr/>
                            <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                          </div>
                        </form>" data-html="true">
                                    <legend class="valtype" data-valtype="text" style="border: 1px dotted #CCC;padding: 15px;margin-bottom: 45px;">Form Name</legend>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid_6 col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Drag & Drop components</h3>
            </div>
            <div class="panel-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="navtab">
                        <li class="active"><a href="#1" data-toggle="tab">Input</a>
                        </li>
                        <li class><a href="#2" data-toggle="tab">Select</a>
                        </li>
                        <li class><a href="#3" data-toggle="tab">Checkbox / Radio</a>
                        </li>
                        <li class><a href="#4" data-toggle="tab">Buttons</a>
                        </li>
                        <li class><a id="sourcetab" href="#5" data-toggle="tab">Rendered</a>
                        </li>
                    </ul>

                    <form class="form-horizontal" id="components">

                        <fieldset>

                            <div class="tab-content">

                                <div class="tab-pane active" id="1">

                                    <div class="form-group component" data-type="text" rel="popover" title="Text Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Placeholder</label> <input type='text' name='placeholder' id='placeholder' class='form-control'>
                              <label class='control-label'>Help Text</label> <input type='text' name='help' id='help' class='form-control'>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">

                                        <!-- Text input-->
                                        <label class="col-md-4 control-label valtype" for="input01" data-valtype='label'>Text input</label>
                                        
                                        <div class="col-md-4">
                                            
                                            <input type="text" placeholder="placeholder" class="form-control input-md valtype" data-valtype="placeholder">
                                            
                                            <p class="help-block valtype" data-valtype='help'>Supporting help text</p>
                                        
                                        </div>

                                    </div>


                                    <div class="form-group component" data-type="search" rel="popover" title="Search Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Placeholder</label> <input type='text' name='placeholder' id='placeholder' class='form-control'>
                              <label class='control-label'>Help Text</label> <input type='text' name='help' id='help' class='form-control'>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">

                                        <!-- Search input-->
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Search input</label>
                                        <div class="col-md-4">
                                            <input type="text" placeholder="placeholder" class="form-control input-md search-query valtype" data-valtype="placeholder">
                                            <p class="help-block valtype" data-valtype="help">Supporting help text</p>
                                        </div>

                                    </div>


                                    <div class="form-group component" data-type="prep-text" rel="popover" title="Prepended Text Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Prepend</label> <input type='text' name='prepend' id='prepend' class='form-control'>
                              <label class='control-label'>Placeholder</label> <input type='text' name='placeholder' id='placeholder' class='form-control'>
                              <label class='control-label'>Help Text</label> <input type='text' name='help' id='help' class='form-control'>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">

                                        <!-- Prepended text-->
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Prepended text</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon valtype" data-valtype="prepend">^_^</span>
                                                <input class="form-control valtype" placeholder="placeholder" id="prependedInput" type="text" data-valtype="placeholder">
                                            </div>
                                            <p class="help-block valtype" data-valtype="help">Supporting help text</p>
                                        </div>

                                    </div>

                                    <div class="form-group component" data-type="app-text" rel="popover" title="Appended Text Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Appepend</label> <input type='text' name='append' id='append' class='form-control'>
                              <label class='control-label'>Placeholder</label> <input type='text' name='placeholder' id='placeholder' class='form-control'>
                              <label class='control-label'>Help Text</label> <input type='text' name='help' id='help' class='form-control'>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">

                                        <!-- Appended input-->
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Appended text</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input name="appendedtext" class="form-control valtype" data-valtype="placeholder" placeholder="placeholder" type="text">
                                                <span class="input-group-addon valtype" data-valtype="append">^_^</span>
                                            </div>
                                            <p class="help-block valtype" data-valtype="help">Supporting help text</p>
                                        </div>


                                    </div>

                                    <div class="form-group component" rel="popover" title="Search Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Placeholder</label> <input type='text' name='placeholder' id='placeholder' class='form-control'>
                              <label class='control-label'>Help Text</label> <input type='text' name='help' id='help' class='form-control'>
                              <label class='checkbox'><input type='checkbox' class='input-inline' name='checked' id='checkbox'>Checked</label>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">

                                        <!-- Prepended checkbox -->
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Prepended checkbox</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" class="valtype" data-valtype="checkbox">
                                                </span>
                                                <input class="form-control valtype" placeholder="placeholder" type="text" data-valtype="placeholder">
                                            </div>
                                            <p class="help-block valtype" data-valtype="help">Supporting help text</p>
                                        </div>

                                    </div>

                                    <div class="form-group component" rel="popover" title="Search Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Placeholder</label> <input type='text' name='placeholder' id='placeholder' class='form-control'>
                              <label class='control-label'>Help Text</label> <input type='text' name='help' id='help' class='form-control'>
                              <label class='checkbox'><input type='checkbox' class='input-inline' name='checked' id='checkbox'>Checked</label>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">

                                        <!-- Appended checkbox -->
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Append checkbox</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input class="form-control valtype" placeholder="placeholder" type="text" data-valtype="placeholder">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" class="valtype" data-valtype="checkbox">
                                                </span>
                                            </div>
                                            <p class="help-block valtype" data-valtype="help">Supporting help text</p>
                                        </div>
                                    </div>

                                    <div class="form-group component" rel="popover" title="Search Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">

                                        <!-- Textarea -->
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Textarea</label>
                                        <div class="col-md-4">
                                            <div class="textarea">
                                                <textarea class="form-control valtype" data-valtype="checkbox" /> </textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane" id="2">

                                    <div class="form-group component" rel="popover" title="Search Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Options: </label>
                              <textarea class='form-control' style='min-height: 200px' id='option'> </textarea>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">

                                        <!-- Select Basic -->
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Select - Basic</label>
                                        <div class="col-md-4">
                                            <select class="form-control input-md valtype" data-valtype="option">
                                                <option>Enter</option>
                                                <option>Your</option>
                                                <option>Options</option>
                                                <option>Here!</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group component" rel="popover" title="Search Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Options: </label>
                              <textarea class='form-control' style='min-height: 200px' id='option'></textarea>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">

                                        <!-- Select Multiple -->
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Select - Multiple</label>
                                        <div class="col-md-4">
                                            <select class="form-control input-md valtype" multiple="multiple" data-valtype="option">
                                                <option>Enter</option>
                                                <option>Your</option>
                                                <option>Options</option>
                                                <option>Here!</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane" id="3">

                                    <div class="form-group component" rel="popover" title="Multiple Checkboxes" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Options: </label>
                              <textarea class='form-control' style='min-height: 200px' id='checkboxes'> </textarea>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Checkboxes</label>
                                        <div class="col-md-4 valtype" data-valtype="checkboxes">

                                            <!-- Multiple Checkboxes -->
                                            <label class="checkbox">
                                                <input type="checkbox" value="Option one"> Option one
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" value="Option two"> Option two
                                            </label>
                                        </div>

                                    </div>

                                    <div class="form-group component" rel="popover" title="Multiple Radios" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Group Name Attribute</label> <input class='form-control' type='text' name='name' id='name'>
                              <label class='control-label'>Options: </label>
                              <textarea class='form-control' style='min-height: 200px' id='radios'></textarea>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Radio buttons</label>
                                        <div class="col-md-4 valtype" data-valtype="radios">

                                            <!-- Multiple Radios -->
                                            <label class="radio">
                                                <input type="radio" value="Option one" name="group" checked="checked"> Option one
                                            </label>
                                            <label class="radio">
                                                <input type="radio" value="Option two" name="group"> Option two
                                            </label>
                                        </div>

                                    </div>

                                    <div class="form-group component" rel="popover" title="Inline Checkboxes" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <textarea class='form-control' style='min-height: 200px' id='inline-checkboxes'></textarea>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Inline Checkboxes</label>

                                        <!-- Multiple Checkboxes -->
                                        <div class="col-md-4 valtype" data-valtype="inline-checkboxes">
                                            <label class="checkbox inline">
                                                <input type="checkbox" value="1"> 1
                                            </label>
                                            <label class="checkbox inline">
                                                <input type="checkbox" value="2"> 2
                                            </label>
                                            <label class="checkbox inline">
                                                <input type="checkbox" value="3"> 3
                                            </label>
                                        </div>

                                    </div>

                                    <div class="form-group component" rel="popover" title="Inline radioes" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Group Name Attribute</label> <input class='form-control' type='text' name='name' id='name'>
                              <textarea class='form-control' style='min-height: 200px' id='inline-radios'></textarea>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Inline radios</label>
                                        <div class="col-md-4 valtype" data-valtype="inline-radios">

                                            <!-- Inline Radios -->
                                            <label class="radio inline">
                                                <input type="radio" value="1" checked="checked" name="group"> 1
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" value="2" name="group"> 2
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" value="3"> 3
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane" id="4">
                                    <div class="form-group component" rel="popover" title="File Upload" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">
                                        <label class="col-md-4 control-label valtype" data-valtype="label">File Button</label>

                                        <!-- File Upload -->
                                        <div class="col-md-4">
                                            <input class="input-file" id="fileInput" type="file">
                                        </div>
                                    </div>

                                    <div class="form-group component" rel="popover" title="Search Input" trigger="manual" data-content="
                          <form class='form'>
                            <div class='form-group col-md-12'>
                              <label class='control-label'>Label Text</label> <input class='form-control' type='text' name='label' id='label'>
                              <label class='control-label'>Button Text</label> <input class='form-control' type='text' name='label' id='button'>
                              <label class='control-label' id=''>Type: </label>
                              <select class='form-control input-md' id='color'>
                                <option id='btn-default'>Default</option>
                                <option id='btn-primary'>Primary</option>
                                <option id='btn-info'>Info</option>
                                <option id='btn-success'>Success</option>
                                <option id='btn-warning'>Warning</option>
                                <option id='btn-danger'>Danger</option>
                                <option id='btn-inverse'>Inverse</option>
                              </select>
                              <hr/>
                              <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                            </div>
                          </form>" data-html="true">
                                        <label class="col-md-4 control-label valtype" data-valtype="label">Button</label>

                                        <!-- Button -->
                                        <div class="col-md-4 valtype" data-valtype="button">
                                            <button class='btn btn-success'>Button</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="5">
                                    <textarea id="source" class="col-md-12"></textarea>
                                </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>