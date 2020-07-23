@extends((isset($package) ? $package . '::' : '') . 'layouts.master')

@section('content')
    <div class="col-sm-12 translation-manager">
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>@lang($package . '::messages.translation-manager')
                            @if(!$disableUiLink)
                                <a style='float: right; font-size: 14px;' href='<?php echo action($controller . '@getUI', []) ?>'>@lang($package . '::messages.try-new-ui')</a>
                            @endif
                        </h1>
                        {{-- csrf_token() --}}
                        {{--{!! $userLocales !!}--}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p>@lang($package . '::messages.export-warning-text') @lang($package.'::messages.powered-by-yandex')</p>
                        <div class="alert alert-danger alert-dismissible" style="display:none;">
                            <button type="button" class="close" data-hide="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="errors-alert">
                            </div>
                        </div>
                        <?php echo ifInPlaceEdit("@lang('$package::messages.import-all-done')") ?>
                        <div class="alert alert-success alert-dismissible" style="display:none;">
                            <button type="button" class="close" data-hide="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="success-import-all">
                                <p>@lang($package . '::messages.import-all-done')</p>
                            </div>
                        </div>
                        <?php echo ifInPlaceEdit("@lang('$package::messages.import-group-done')", ['group' => $group]) ?>
                        <div class="alert alert-success alert-dismissible" style="display:none;">
                            <button type="button" class="close" data-hide="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="success-import-group">
                                <p>@lang($package . '::messages.import-group-done', ['group' => $group]) </p>
                            </div>
                        </div>
                        <?php echo ifInPlaceEdit("@lang('$package::messages.search-done')") ?>
                        <div class="alert alert-success alert-dismissible" style="display:none;">
                            <button type="button" class="close" data-hide="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="success-find">
                                <p>@lang($package . '::messages.search-done')</p>
                            </div>
                        </div>
                        <?php echo ifInPlaceEdit("@lang('$package::messages.done-publishing')", ['group' => $group]) ?>
                        <div class="alert alert-success alert-dismissible" style="display:none;">
                            <button type="button" class="close" data-hide="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="success-publish">
                                <p>@lang($package . '::messages.done-publishing', ['group'=> $group])</p>
                            </div>
                        </div>
                        <?php echo ifInPlaceEdit("@lang('$package::messages.done-publishing-all')") ?>
                        <div class="alert alert-success alert-dismissible" style="display:none;">
                            <button type="button" class="close" data-hide="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="success-publish-all">
                                <p>@lang($package . '::messages.done-publishing-all')</p>
                            </div>
                        </div>
                        <?php if(Session::has('successPublish')) : ?>
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-hide="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo Session::get('successPublish'); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        @if($adminEnabled)
                            <div class="row">
                                <div class="col-sm-12">
                                    <form id="form-import-all" class="form-import-all" method="POST"
                                            action="<?php echo action($controller . '@postImport', ['group' => '*']) ?>"
                                            data-remote="true" role="form">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php echo ifEditTrans($package . '::messages.import-add') ?>
                                                <?php echo ifEditTrans($package . '::messages.import-replace') ?>
                                                <?php echo ifEditTrans($package . '::messages.import-fresh') ?>
                                                <div class="input-group-sm">
                                                    <select name="replace" class="import-select form-control">
                                                        <option value="0"><?php echo noEditTrans($package . '::messages.import-add') ?></option>
                                                        <option value="1"><?php echo noEditTrans($package . '::messages.import-replace') ?></option>
                                                        <option value="2"><?php echo noEditTrans($package . '::messages.import-fresh') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php echo ifEditTrans($package . '::messages.import-all-groups') ?>
                                                <?php echo ifEditTrans($package . '::messages.loading') ?>
                                                <button id="submit-import-all" type="submit" form="form-import-all"
                                                        class="btn btn-sm btn-success"
                                                        data-disable-with="<?php echo noEditTrans($package . '::messages.loading') ?>">
                                                    <?php echo noEditTrans($package . '::messages.import-all-groups') ?>
                                                </button>
                                                <?php echo ifEditTrans($package . '::messages.zip-all') ?>
                                                <a href="<?php echo action($controller . '@getZippedTranslations', ['group' => '*']) ?>"
                                                        role="button" class="btn btn-primary btn-sm">
                                                    <?php echo noEditTrans($package . '::messages.zip-all') ?>
                                                </a>
                                                <div class="input-group" style="float:right; display:inline">
                                                    <?php echo ifEditTrans($package . '::messages.publish-all-groups') ?>
                                                    <?php echo ifEditTrans($package . '::messages.publishing') ?>
                                                    <button type="submit" form="form-publish-all"
                                                            class="btn btn-sm btn-warning input-control"
                                                            data-disable-with="<?php echo noEditTrans($package . '::messages.publishing') ?>">
                                                        <?php echo noEditTrans($package . '::messages.publish-all-groups') ?>
                                                    </button>
                                                    <?php echo ifEditTrans($package . '::messages.add-references') ?>
                                                    <?php echo ifEditTrans($package . '::messages.searching') ?>
                                                    <button type="submit" form="form-find"
                                                            class="btn btn-sm btn-danger"
                                                            data-disable-with="<?php echo noEditTrans($package . '::messages.searching') ?>">
                                                        <?php echo noEditTrans($package . '::messages.add-references') ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php echo ifEditTrans($package . '::messages.confirm-find') ?>
                                    <form id="form-find" class="form-inline form-find" method="POST"
                                            action="<?php echo action($controller . '@postFind') ?>"
                                            data-remote="true" role="form"
                                            data-confirm="<?php echo noEditTrans($package . '::messages.confirm-find') ?>">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div style="min-height: 10px"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php echo ifEditTrans($package . '::messages.choose-group'); ?>
                                        <div class="input-group-sm">
                                            <?php echo Form::select(
                                                'group', $groups, $group, array(
                                                'form' => 'form-select', 'class' => 'group-select form-control'
                                                )
                                            ) ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php if ($adminEnabled) : ?>
                                            <?php if ($group) : ?>
                                                <?php echo ifEditTrans($package . '::messages.publishing') ?>
                                                <?php echo ifEditTrans($package . '::messages.publish') ?>
                                        <button type="submit" form="form-publish-group"
                                                class="btn btn-sm btn-info input-control"
                                                data-disable-with="<?php echo noEditTrans($package . '::messages.publishing') ?>">
                                                <?php echo noEditTrans($package . '::messages.publish') ?>
                                        </button>
                                                <?php echo ifEditTrans($package . '::messages.zip-group') ?>
                                        <a href="<?php echo action($controller . '@getZippedTranslations', ['group' => $group]) ?>"
                                                role="button" class="btn btn-primary btn-sm">
                                                <?php echo noEditTrans($package . '::messages.zip-group') ?>
                                        </a>
                                                <?php echo ifEditTrans($package . '::messages.search'); ?>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#searchModal"><?php echo noEditTrans($package . '::messages.search') ?></button>
                                            <?php endif; ?>
                                        <div class="input-group" style="float:right; display:inline">
                                            <?php if ($group) : ?>
                                                <?php echo ifEditTrans($package . '::messages.import-group') ?>
                                                <?php echo ifEditTrans($package . '::messages.loading') ?>
                                            <button type="submit" form="form-import-group" class="btn btn-sm btn-success"
                                                    data-disable-with="<?php echo noEditTrans($package . '::messages.loading') ?>">
                                                <?php echo noEditTrans($package . '::messages.import-group') ?>
                                            </button>
                                                <?php echo ifEditTrans($package . '::messages.delete-group') ?>
                                                <?php echo ifEditTrans($package . '::messages.deleting') ?>
                                            <button type="submit" form="form-delete-group" class="btn btn-sm btn-danger"
                                                    data-disable-with="<?php echo noEditTrans($package . '::messages.deleting') ?>">
                                                <?php echo noEditTrans($package . '::messages.delete-group') ?>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                        <?php else: ?>
                                            <?php if ($group) : ?>
                                                <?php echo ifEditTrans($package . '::messages.search'); ?>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#searchModal"><?php echo noEditTrans($package . '::messages.search') ?></button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($group) : ?>
                                        <?php echo ifEditTrans($package . '::messages.confirm-delete') ?>
                                        <form id="form-delete-group" class="form-inline form-delete-group" method="POST"
                                                action="<?php echo action($controller . '@postDeleteAll', $group) ?>"
                                                data-remote="true" role="form"
                                                data-confirm="<?php echo noEditTrans($package . '::messages.confirm-delete', ['group' => $group]) ?>">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        </form>
                                        <form id="form-import-group" class="form-inline form-import-group" method="POST"
                                                action="<?php echo action($controller . '@postImport', $group) ?>"
                                                data-remote="true" role="form">
                                            <input type="hidden" name="_token"
                                                    value="<?php echo csrf_token(); ?>">
                                        </form>
                                        <form role="form" class="form" id="form-select"></form>
                                        <form id="form-publish-group" class="form-inline form-publish-group" method="POST"
                                                action="<?php echo action($controller . '@postPublish', $group) ?>"
                                                data-remote="true" role="form">
                                            <input type="hidden" name="_token"
                                                    value="<?php echo csrf_token(); ?>">
                                        </form>
                                    <?php endif; ?>    
                                    <form id="form-publish-all" class="form-inline form-publish-all" method="POST"
                                            action="<?php echo action($controller . '@postPublish', '*') ?>"
                                            data-remote="true" role="form">
                                        <input type="hidden" name="_token"
                                                value="<?php echo csrf_token(); ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div style="min-height: 10px"></div>
                        <div class="row">
                            <?php if(!$group) : ?>
                            <div class="col-sm-10">
                                <p>@lang($package . '::messages.choose-group-text')</p>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#searchModal" style="float:right; display:inline">
                                    <?php echo noEditTrans($package . '::messages.search') ?>
                                </button>
                                <?php echo ifEditTrans($package . '::messages.search') ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div style="min-height: 10px"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12">
                        <div style="min-height: 10px"></div>
                        <form class="form-inline" id="form-interface-locale" method="GET"
                                action="<?php echo action($controller . '@getTranslationLocales') ?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="row">
                                <div class=" col-sm-3">
                                    @if($adminEnabled && count($connection_list) > 1)
                                        <div class="input-group-sm">
                                            <label for="db-connection"><?php echo trans($package . '::messages.db-connection') ?>:</label>
                                            <br>
                                            <select name="c" id="db-connection" class="form-control">
                                                @foreach($connection_list as $connection => $description)
                                                    <option value="<?php echo $connection?>"<?php echo $connection_name === $connection ? ' selected="selected"' : ''?>><?php echo $description ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        &nbsp;
                                    @endif
                                </div>
                                <div class=" col-sm-2">
                                    <div class="input-group-sm">
                                        <label for="interface-locale"><?php echo trans($package . '::messages.interface-locale') ?>:</label>
                                        <br>
                                        <select name="l" id="interface-locale" class="form-control">
                                            @foreach($locales as $locale)
                                                <option value="<?php echo $locale?>"<?php echo $currentLocale === $locale ? ' selected="selected"' : ''?>><?php echo $locale ?></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-2">
                                    <div class="input-group-sm">
                                        <label for="translating-locale"><?php echo trans($package . '::messages.translating-locale') ?>:</label>
                                        <br>
                                        <select name="t" id="translating-locale" class="form-control">
                                            @foreach($locales as $locale)
                                                @if($locale !== $primaryLocale)
                                                    <option value="<?php echo $locale?>"<?php echo $translatingLocale === $locale ? ' selected="selected"' : ''?>><?php echo $locale ?></option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-2">
                                    <div class="input-group-sm">
                                        <label for="primary-locale"><?php echo trans($package . '::messages.primary-locale') ?>:</label>
                                        <br>
                                        <select name="p" id="primary-locale" class="form-control">
                                            @foreach($locales as $locale)
                                                <option value="<?php echo $locale?>"<?php echo $primaryLocale === $locale ? ' selected="selected"' : ''?>><?php echo $locale ?></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <?php if(str_contains($userLocales, ',' . $currentLocale . ',')) : ?>
                                    <div class="input-group input-group-sm" style="float:right; display:inline">
                                        <?php echo ifEditTrans($package . '::messages.in-place-edit') ?>
                                        <label for="edit-in-place">&nbsp;</label>
                                        <br>
                                        <a class="btn btn-sm btn-primary" role="button" id="edit-in-place" href="<?php echo action($controller . '@getToggleInPlaceEdit') ?>">
                                            <?php echo noEditTrans($package . '::messages.in-place-edit') ?>
                                        </a>
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div style="min-height: 10px"></div>
                            <div class="row">
                                <div class=" col-sm-4">
                                    <div class="row">
                                        <div class=" col-sm-12">
                                            <?php echo formSubmit(trans($package . '::messages.display-locales'), ['class' => "btn btn-sm btn-primary"]) ?>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class=" col-sm-12">
                                            <div style="min-height: 10px"></div>
                                            <?php echo ifEditTrans($package . '::messages.check-all') ?>
                                            <button id="display-locale-all"
                                                    class="btn btn-sm btn-default"><?php echo noEditTrans($package . '::messages.check-all')?></button>
                                            <?php echo ifEditTrans($package . '::messages.check-none') ?>
                                            <button id="display-locale-none"
                                                    class="btn btn-sm btn-default"><?php echo noEditTrans($package . '::messages.check-none')?></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class=" col-sm-12">
                                            <div style="min-height: 10px"></div>
                                            <?php echo ifEditTrans($package . '::messages.show-published-site') ?>
                                            <?php echo ifEditTrans($package . '::messages.show-unpublished-site') ?>
                                            <a class="btn btn-xs btn-default" role="button" id="show-unpublished-site" href="<?php echo action($controller . '@getToggleShowUnpublished') ?>">
                                                <?php echo noEditTrans($package . ($show_unpublished ? '::messages.show-published-site' : '::messages.show-unpublished-site')) ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-sm-8">
                                    <div class="input-group-sm">
                                        @foreach($locales as $locale)
                                            <label>
                                                <input <?php echo $locale !== $primaryLocale && $locale !== $translatingLocale ? ' class="display-locale" ' : '' ?> name="d[]"
                                                        type="checkbox"
                                                        value="<?php echo $locale?>"
                                                <?php echo ($locale === $primaryLocale || $locale === $translatingLocale || array_search($locale, $displayLocales) !== false) ? 'checked' : '' ?>
                                                    <?php echo $locale === $primaryLocale || $locale === $translatingLocale ? ' disabled' : '' ?>><?php echo $locale ?>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if($usage_info_enabled)
                    <div class="row">
                        <div class="col-sm-12">
                            <div style="min-height: 10px"></div>
                            <form class="form-inline" id="form-usage-info" method="GET"
                                    action="<?php echo action($controller . '@getUsageInfo') ?>">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="group" value="<?php echo $group ? $group : '*'; ?>">
                                <div class="row">
                                    <div class=" col-sm-12">
                                        <div class="row">
                                            <div class=" col-sm-4">
                                                <div class="row">
                                                    <div class=" col-sm-12">
                                                        <?php echo formSubmit(trans($package . '::messages.set-usage-info'), ['class' => "btn btn-sm btn-primary"]) ?>&nbsp;&nbsp;
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-8">
                                                <label>
                                                    <input id="show-usage-info" name="show-usage-info" type="checkbox" value="1" {!! $show_usage ? 'checked' : '' !!}>
                                                    {!! trans($package . '::messages.show-usage-info') !!}
                                                </label>
                                                <label>
                                                    <input id="reset-usage-info" name="reset-usage-info" type="checkbox" value="1">
                                                    {!! trans($package . '::messages.reset-usage-info') !!}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <br>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        @include($package . '::dashboard')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        @if($mismatchEnabled && !empty($mismatches))
                            @include($package . '::mismatched')
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        @if($adminEnabled && $userLocalesEnabled && !$group)
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">@lang($package . '::messages.user-admin')</h3>
                                </div>
                                <div class="panel-body">
                                    @include($package . '::user_locales')
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <?php echo ifEditTrans($package . '::messages.enter-translation') ?>
        <?php echo ifEditTrans($package . '::messages.mismatched-quotes') ?>
        <?php if($group) : ?>
        <div class="row">
            <div class="col-sm-12 ">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @if($adminEnabled && $userLocalesEnabled)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingUserAdmin">
                                <?php echo ifEditTrans($package . '::messages.user-admin') ?>
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseUserAdmin"
                                            aria-expanded="false" aria-controls="collapseUserAdmin">
                                        <?php echo noEditTrans($package . '::messages.user-admin') ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseUserAdmin" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingUserAdmin">
                                <div class="panel-body">
                                    <div class="col-sm-12">
                                        @include($package . '::user_locales')
                                    </div>
                                </div>
                            </div>
                        </div>
        <?php endif; ?>
                        <?php if($adminEnabled) : ?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <?php echo ifEditTrans($package . '::messages.suffixed-keyops') ?>
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne">
                                        <?php echo noEditTrans($package . '::messages.suffixed-keyops') ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <!-- Add Keys Form -->
                                    <div class="col-sm-12">
                                        <?php echo  Form::open(['id' => 'form-addkeys', 'method' => 'POST', 'action' => [$controller . '@postAddSuffixedKeys', $group]]) ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="keys">@lang($package . '::messages.keys'):</label><?php echo ifEditTrans($package . '::messages.addkeys-placeholder') ?>
                                                <?php echo  Form::textarea(
                                                    'keys', Request::old('keys'), [
                                                    'class' => "form-control", 'rows' => "4", 'style' => "resize: vertical", 'placeholder' => noEditTrans($package . '::messages.addkeys-placeholder')
                                                    ]
                                                ) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="suffixes">@lang($package . '::messages.suffixes'):</label><?php echo ifEditTrans($package . '::messages.addsuffixes-placeholder') ?>
                                                <?php echo  Form::textarea(
                                                    'suffixes', Request::old('suffixes'), [
                                                    'class' => "form-control", 'rows' => "4", 'style' => "resize: vertical", 'placeholder' => noEditTrans($package . '::messages.addsuffixes-placeholder')
                                                    ]
                                                ) ?>
                                            </div>
                                        </div>
                                        <div style="min-height: 10px"></div>
                                        <script>
                                            var currentGroup = '{{$group}}';
                                            function addStandardSuffixes(event) {
                                                event.preventDefault();
                                                $("#form-addkeys").first().find("textarea[name='suffixes']")[0].value = "-type\n-header\n-heading\n-description\n-footer" + (currentGroup === 'systemmessage-texts' ? '\n-footing' : '');
                                            }
                                            function clearSuffixes(event) {
                                                event.preventDefault();
                                                $("#form-addkeys").first().find("textarea[name='suffixes']")[0].value = "";
                                            }
                                            function clearKeys(event) {
                                                event.preventDefault();
                                                $("#form-addkeys").first().find("textarea[name='keys']")[0].value = "";
                                            }
                                            function postDeleteSuffixedKeys(event) {
                                                event.preventDefault();
                                                var elem = $("#form-addkeys").first();
                                                elem[0].action = "<?php echo action($controller . '@postDeleteSuffixedKeys', $group)?>";
                                                elem[0].submit();
                                            }
                                        </script>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php echo formSubmit(trans($package . '::messages.addkeys'), ['class' => "btn btn-sm btn-primary"]) ?>
                                                <?php echo ifEditTrans($package . '::messages.clearkeys') ?>
                                                <button class="btn btn-sm btn-primary"
                                                        onclick="clearKeys(event)"><?php echo noEditTrans($package . '::messages.clearkeys') ?>
                                                </button>
                                                <div class="input-group" style="float:right; display:inline">
                                                    <?php echo ifEditTrans($package . '::messages.deletekeys') ?>
                                                    <button class="btn btn-sm btn-danger"
                                                            onclick="postDeleteSuffixedKeys(event)">
                                                        <?php echo noEditTrans($package . '::messages.deletekeys') ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <?php echo ifEditTrans($package . '::messages.addsuffixes') ?>
                                                <button class="btn btn-sm btn-primary"
                                                        onclick="addStandardSuffixes(event)"><?php echo noEditTrans($package . '::messages.addsuffixes') ?></button>
                                                <?php echo ifEditTrans($package . '::messages.clearsuffixes') ?>
                                                <button class="btn btn-sm btn-primary"
                                                        onclick="clearSuffixes(event)"><?php echo noEditTrans($package . '::messages.clearsuffixes') ?></button>
                                            </div>
                                            <div class="col-sm-2">
                                                <span style="float:right; display:inline">
                                                    <?php echo ifEditTrans($package . '::messages.search'); ?>
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                            data-target="#searchModal"><?php echo noEditTrans($package . '::messages.search') ?></button>
                                                </span>
                                            </div>
                                        </div>
                                        <?php echo  Form::close() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <?php echo ifEditTrans($package . '::messages.wildcard-keyops') ?>
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                        <?php echo noEditTrans($package . '::messages.wildcard-keyops') ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <div class="col-sm-12">
                                        <!-- Key Ops Form -->
                                        <div id="wildcard-keyops-results" class="results"></div>
                                        <?php echo  Form::open(
                                            [
                                            'id' => 'form-keyops', 'data-remote' => "true", 'method' => 'POST', 'action' => [$controller . '@postPreviewKeys', $group]
                                            ]
                                        ) ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="srckeys">@lang($package . '::messages.srckeys'):</label><?php echo ifEditTrans($package . '::messages.srckeys-placeholder') ?>
                                                <?php echo  Form::textarea(
                                                    'srckeys', Request::old('srckeys'), [
                                                    'id' => 'srckeys', 'class' => "form-control", 'rows' => "4", 'style' => "resize: vertical", 'placeholder' => noEditTrans($package . '::messages.srckeys-placeholder')
                                                    ]
                                                ) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="dstkeys">@lang($package . '::messages.dstkeys'):</label><?php echo ifEditTrans($package . '::messages.dstkeys-placeholder') ?>
                                                <?php echo  Form::textarea(
                                                    'dstkeys', Request::old('dstkeys'), [
                                                    'id' => 'dstkeys', 'class' => "form-control", 'rows' => "4", 'style' => "resize: vertical", 'placeholder' => noEditTrans($package . '::messages.dstkeys-placeholder')
                                                    ]
                                                ) ?>
                                            </div>
                                        </div>
                                        <div style="min-height: 10px"></div>
                                        <script>
                                            var currentGroup = '{{$group}}';
                                            function clearDstKeys(event) {
                                                event.preventDefault();
                                                $("#form-keyops").first().find("textarea[name='dstkeys']")[0].value = "";
                                            }
                                            function clearSrcKeys(event) {
                                                event.preventDefault();
                                                $("#form-keyops").first().find("textarea[name='srckeys']")[0].value = "";
                                            }
                                            function postPreviewKeys(event) {
                                                //event.preventDefault();
                                                var elem = $("#form-keyops").first();
                                                elem[0].action = "<?php echo action($controller . '@postPreviewKeys', $group)?>";
                                                //elem[0].submit();
                                            }
                                            function postMoveKeys(event) {
                                                //event.preventDefault();
                                                var elem = $("#form-keyops").first();
                                                elem[0].action = "<?php echo action($controller . '@postMoveKeys', $group)?>";
                                                //elem[0].submit();
                                            }
                                            function postCopyKeys(event) {
                                                //event.preventDefault();
                                                var elem = $("#form-keyops").first();
                                                elem[0].action = "<?php echo action($controller . '@postCopyKeys', $group)?>";
                                                //elem[0].submit();
                                            }
                                            function postDeleteKeys(event) {
                                                //event.preventDefault();
                                                var elem = $("#form-keyops").first();
                                                elem[0].action = "<?php echo action($controller . '@postDeleteKeys', $group)?>";
                                                //elem[0].submit();
                                            }
                                        </script>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php echo ifEditTrans($package . '::messages.clearsrckeys') ?>
                                                <button class="btn btn-sm btn-primary"
                                                        onclick="clearSrcKeys(event)"><?php echo noEditTrans($package . '::messages.clearsrckeys') ?></button>
                                                <div class="input-group" style="float:right; display:inline">
                                                    <?php echo formSubmit(
                                                        trans($package . '::messages.preview'), [
                                                        'class' => "btn btn-sm btn-primary", 'onclick' => 'postPreviewKeys(event)'
                                                        ]
                                                    ) ?>
                                                    <?php echo ifEditTrans($package . '::messages.copykeys'); ?>
                                                    <button class="btn btn-sm btn-primary" onclick="postCopyKeys(event)">
                                                        <?php echo noEditTrans($package . '::messages.copykeys') ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php echo ifEditTrans($package . '::messages.cleardstkeys') ?>
                                                <button class="btn btn-sm btn-primary"
                                                        onclick="clearDstKeys(event)"><?php echo noEditTrans($package . '::messages.cleardstkeys') ?></button>
                                                <div class="input-group" style="float:right; display:inline">
                                                    <?php echo ifEditTrans($package . '::messages.movekeys') ?>
                                                    <button class="btn btn-sm btn-warning" onclick="postMoveKeys(event)">
                                                        <?php echo noEditTrans($package . '::messages.movekeys') ?>
                                                    </button>
                                                    <?php echo ifEditTrans($package . '::messages.deletekeys') ?>
                                                    <button class="btn btn-sm btn-danger" onclick="postDeleteKeys(event)">
                                                        <?php echo noEditTrans($package . '::messages.deletekeys') ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo  Form::close() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        @if($yandex_key)
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <?php echo ifEditTrans($package . '::messages.translation-ops') ?>
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <?php echo noEditTrans($package . '::messages.translation-ops') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                        aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                        <textarea id="primary-text" class="form-control" rows="3" name="keys"
                                                style="resize: vertical;" placeholder="<?php echo $primaryLocale ?>"></textarea>
                                                <div style="min-height: 10px"></div>
                                                <span>@lang($package.'::messages.powered-by-yandex')</span> <span style="float:right; display:inline">
                                            <button id="translate-primary-current" type="button" class="btn btn-sm btn-primary">
                                                <?php echo $primaryLocale ?>&nbsp;<i class="glyphicon glyphicon-share-alt"></i>&nbsp;<?php echo $translatingLocale ?>
                                            </button>
                                        </span>
                                            </div>
                                            <div class="col-sm-6">
                                        <textarea id="current-text" class="form-control" rows="3" name="keys"
                                                style="resize: vertical;" placeholder="<?php echo $translatingLocale ?>"></textarea>
                                                <div style="min-height: 10px"></div>
                                                <button id="translate-current-primary" type="button" class="btn btn-sm btn-primary">
                                                    <?php echo $translatingLocale ?>&nbsp;<i class="glyphicon glyphicon-share-alt"></i>&nbsp;<?php echo $primaryLocale ?>
                                                </button>
                                                <span style="float:right; display:inline">@lang($package.'::messages.powered-by-yandex')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 ">
                <label for="show-matching-text" id="show-matching-text-label" class="regex-error">&nbsp;</label>
                <div class="form-inline">
                    <?php echo ifEditTrans($package . '::messages.show-matching-text') ?>
                    <div class="input-group input-group-sm">
                        <input class="form-control" style="width: 200px;" id="show-matching-text" type="text" placeholder="{{noEditTrans($package . '::messages.show-matching-text')}}">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" id="show-matching-clear" style="margin-right: 15px;">
                                &times;
                            </button>
                        </span>
                    </div>
                    <div class="input-group input-group-sm translation-filter">
                        {{--<label>@lang($package . '::messages.show'):&nbsp;</label>--}}
                        <label class="radio-inline">
                            <input id="show-all" type="radio" name="show-options" value="show-all"> @lang($package . '::messages.show-all')
                        </label>
                    </div>
                    <div class="input-group input-group-sm translation-filter">
                        <label class="radio-inline">
                            <input id="show-new" type="radio" name="show-options" value="show-new"> @lang($package . '::messages.show-new')
                        </label>
                    </div>
                    <div class="input-group input-group-sm translation-filter">
                        <label class="radio-inline">
                            <input id="show-need-attention" type="radio" name="show-options" value="show-need-attention"> @lang($package . '::messages.show-need-attention')
                        </label>
                    </div>
                    <div class="input-group input-group-sm translation-filter">
                        <label class="radio-inline">
                            <input id="show-nonempty" type="radio" name="show-options" value="show-nonempty"> @lang($package . '::messages.show-nonempty')
                        </label>
                    </div>
                    <div class="input-group input-group-sm translation-filter">
                        <label class="radio-inline">
                            <input id="show-used" type="radio" name="show-options" value="show-used"> @lang($package . '::messages.show-used')
                        </label>
                    </div>
                    <div class="input-group input-group-sm translation-filter">
                        <label class="radio-inline">
                            <input id="show-unpublished" type="radio" name="show-options" value="show-unpublished"> @lang($package . '::messages.show-unpublished')
                        </label>
                    </div>
                    <div class="input-group input-group-sm translation-filter">
                        <label class="radio-inline">
                            <input id="show-empty" type="radio" name="show-options" value="show-empty"> @lang($package . '::messages.show-empty')
                        </label>
                    </div>
                    <div class="input-group input-group-sm translation-filter">
                        <label class="radio-inline">
                            <input id="show-changed" type="radio" name="show-options" value="show-changed"> @lang($package . '::messages.show-changed')
                        </label>
                    </div>
                    <div class="input-group input-group-sm translation-filter">
                        <label class="radio-inline">
                            <input id="show-deleted" type="radio" name="show-options" value="show-deleted"> @lang($package . '::messages.show-deleted')
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 ">
                <div style="min-height: 10px"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 ">
                @include($package . '::translations-table')
            </div>
        </div>
    <?php endif; ?>
    <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="searchModalLabel">@lang($package . '::messages.search-translations')</h4>
                    </div>
                    <div class="modal-body">
                        <form id="search-form" method="GET" action="<?php echo action($controller . '@getSearch') ?>" data-remote="true">
                            <div class="form-group">
                                <div class="input-group">
                                    <input id="search-form-text" type="search" name="q" class="form-control">
                                    <span class="input-group-btn">
                                        <?php echo formSubmit(trans($package . '::messages.search'), ['class' => "btn btn-default"]) ?>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="results"></div>
                    </div>
                    <div class="modal-footer">
                        <?php echo ifEditTrans($package . '::messages.close') ?>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo noEditTrans($package . '::messages.close') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- KeyOp Modal -->
        <div class="modal fade" id="keyOpModal" tabindex="-1" role="dialog" aria-labelledby="keyOpModalLabel"
                aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="keyOpModalLabel">@lang($package . '::messages.keyop-header')</h4>
                    </div>
                    <div class="modal-body">
                        <div class="results"></div>
                    </div>
                    <div class="modal-footer">
                        <?php echo ifEditTrans($package . '::messages.close') ?>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo noEditTrans($package . '::messages.close') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Source Refs Modal -->
        <div class="modal fade" id="sourceRefsModal" tabindex="-1" role="dialog" aria-labelledby="keySourceRefsModal"
                aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="keySourceRefsModal">@lang($package . '::messages.source-refs-header')
                                <code style="color:white">'<span id="key-name"></span>'</code></h4>
                    </div>
                    <div class="modal-body">
                        <div class="results"></div>
                    </div>
                    <div class="modal-footer">
                        <?php echo ifEditTrans($package . '::messages.close') ?>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo noEditTrans($package . '::messages.close') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('body-bottom')
    <script>
        var URL_YANDEX_TRANSLATOR_KEY = '<?php echo action($controller . '@postYandexKey') ?>';
        var PRIMARY_LOCALE = '{{$primaryLocale}}';
        var CURRENT_LOCALE = '{{$currentLocale}}';
        var TRANSLATING_LOCALE = '{{$translatingLocale}}';
        var URL_TRANSLATOR_GROUP = '<?php echo action($controller . '@getView') ?>/';
        var URL_TRANSLATOR_ALL = '<?php echo action($controller . '@getIndex') ?>';
        var URL_TRANSLATOR_FILTERS = '<?php echo action($controller . '@getTransFilters') ?>';
        var CURRENT_GROUP = '<?php echo $group ?>';
        var MARKDOWN_KEY_SUFFIX = '<?php echo $markdownKeySuffix ?>';
        
        // provide translations for JavaScript
        var MISMATCHED_QUOTES_MESSAGE = "<?php echo noEditTrans(($package . '::messages.mismatched-quotes'))?>";
        var TITLE_SAVE_CHANGES = "<?php echo noEditTrans(($package . '::messages.title-save-changes'))?>";
        var TITLE_CANCEL_CHANGES = "<?php echo noEditTrans(($package . '::messages.title-cancel-changes'))?>";
        var TITLE_TRANSLATE = "<?php echo noEditTrans(($package . '::messages.title-translate'))?>";
        var TITLE_CONVERT_KEY = "<?php echo noEditTrans(($package . '::messages.title-convert-key'))?>";
        var TITLE_GENERATE_PLURALS = "<?php echo noEditTrans(($package . '::messages.title-generate-plurals'))?>";
        var TITLE_CLEAN_HTML_MARKDOWN = "<?php echo noEditTrans(($package . '::messages.title-clean-html-markdown'))?>";
        var TITLE_CAPITALIZE = "<?php echo noEditTrans(($package . '::messages.title-capitalize'))?>";
        var TITLE_LOWERCASE = "<?php echo noEditTrans(($package . '::messages.title-lowercase'))?>";
        var TITLE_CAPITALIZE_FIRST_WORD = "<?php echo noEditTrans(($package . '::messages.title-capitalize-first-word'))?>";
        var TITLE_SIMULATED_COPY = "<?php echo noEditTrans(($package . '::messages.title-simulated-copy'))?>";
        var TITLE_SIMULATED_PASTE = "<?php echo noEditTrans(($package . '::messages.title-simulated-paste'))?>";
        var TITLE_RESET_EDITOR = "<?php echo noEditTrans(($package . '::messages.title-reset-editor'))?>";
        var TITLE_LOAD_LAST = "<?php echo noEditTrans(($package . '::messages.title-load-last'))?>";
    </script>

    <!-- Moved out to allow auto-format in PhpStorm w/o screwing up HTML format -->
    <script src="<?php echo  $public_prefix . $package ?>/js/xregexp-all.js"></script>
    <script src="<?php echo  $public_prefix . $package ?>/js/translations_page.js"></script>

    <?php
    $userLocaleList = [];
    foreach ($userList as $user) {
        if ($user->locales) {
            foreach (explode(",", $user->locales) as $userLocale) {
                $userLocale = trim($userLocale);
                if ($userLocale) { $userLocaleList[] = $userLocale;
                }
            }
        }
    }

    foreach ($displayLocales as $userLocale) {
        $userLocaleList[] = $userLocale;
    }

    $userLocaleList = array_unique($userLocaleList);
    natsort($userLocaleList);
    ?>

    <script>
var TRANS_FILTERS = ({
filter: "<?php echo isset($transFilters['filter']) ? $transFilters['filter'] : "" ?>",
regex: "<?php echo isset($transFilters['regex']) ? $transFilters['regex'] : ""  ?>"
});

<?php $addComma = false; ?>
var USER_LOCALES = [
<?php foreach ($userLocaleList as $locale): ?>
    <?php if ($addComma) { echo ","; 
    } else { $addComma = true;
    } ?> { value: '<?php echo $locale ?>', text: '<?php echo $locale ?>' }
<?php endforeach; ?>
];
    </script>
@stop

