<table class="table table-condensed translation-stats">
    <thead>
        <tr>
            <th width="5%">@lang($package . '::messages.user-id')</th>
            <th width="30%">@lang($package . '::messages.user-email')</th>
            <th width="25%">@lang($package . '::messages.user-name')</th>
            <th width="40%">@lang($package . '::messages.user-locales')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($userList as $user)
            <tr>
                <td><?php echo $user->id ?: '&nbsp;'?></td>
                <td><?php echo $user->email ?: '&nbsp;'?></td>
                <td><?php echo isset($user->name) && $user->name ? $user->name : '&nbsp;'?></td>
                <td>
                    <a href="#" class="user-locales" data-type="checklist" data-pk="<?php echo $user->id ?>" data-url="<?php echo action($controller . '@postUserLocales') ?>" data-title="Select User Locales"
                            data-value="<?php echo $user->locales ?>"
                    ><?php echo $user->locales ?: '&nbsp;'?></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
