<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use Str;

class NotificationController
{

    public function getNotificationsData(Request $request)
    {
        // Create array of available colors.

        $colors = [
            'dark', 'primary', 'secondary', 'success', 'warning', 'danger'
        ];


        $notifications = Auth::user()->unreadNotifications;

        $dropdownHtml = '';

        foreach ($notifications as $key => $notification) {
            $fa = $notification->unread() ? 'fa-envelope text-red' : 'fa-envelope-open text-green';
            $icon = "<i class='mr-2 fas fa-fw {$fa}'></i>";

            $time = "<span class='float-right text-muted text-sm'>
                       {$notification->created_at->diffForHumans()}
                     </span>";

            $text = Str::limit($notification->data['message'] ?? '', 30);
            //$url = $notification->data['url'];


            $dropdownHtml .= "<a href='#' class='dropdown-item'>
                                {$icon}<br>{$text}{$time}
                              </a>";

            //   if ($key < count($not)) {
            $dropdownHtml .= "<div class='dropdown-divider'></div>";
            //}

            if ($key == 4) break;
        }

        // Return the new notification data.

        return [
            'label' => $notifications->count(),
            'label_color' => $colors[rand(0, 5)],
            'icon_color' => $colors[rand(0, 5)],
            'dropdown' => $dropdownHtml,
        ];
    }

}
