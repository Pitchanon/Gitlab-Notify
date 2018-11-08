<?php

namespace Pitchanon\GitlabNotify;

class GitlabNotify {

  private static $line;

  public static function Config($config = []) {
    if (!isset(self::$line) || empty(self::$line)) {
      self::$line = new \Pitchanon\Line\Notify($config);
    }
    return self::$line;
  }

  public static function Notify(string $entityBody) {
    $entityBodyObj = json_decode($entityBody);
    $message = "";
    $event = "";

    if (isset($entityBodyObj->event_name)) {
      $event = $entityBodyObj->event_name;
    }
    elseif (isset($entityBodyObj->event_type)) {
      $event = $entityBodyObj->event_type;
    }
    switch ($event) {
      case "project_create":
        $message .= "Project create \n\nName: " . $entityBodyObj->name . "\nPath: " . $entityBodyObj->path_with_namespace . "\n\nOwner name: " . $entityBodyObj->owner_name;
        break;
      case "project_destroy":
        $message .= "";
      case "project_rename":
        $message .= "";
      case "project_transfer":
        $message .= "";
      case "project_update":
        $message .= "";
      case "user_remove_from_team":
        $message .= "";
      case "user_create":
        $message .= "";
      case "user_destroy":
        $message .= "";
      case "user_failed_login":
        $message .= "";
      case "user_rename":
        $message .= "";
      case "user_add_to_group":
        $message .= "";
      case "user_remove_from_group":
        $message .= "";
      case "user_add_to_team":
        $message .= "User add to team\n\nProject name: " . $entityBodyObj->project_path_with_namespace . "\nUser name: " . $entityBodyObj->user_username . "\nAccess level: " . $entityBodyObj->access_level;
        break;
      case "key_create":
        $message .= "";
      case "key_destroy":
        $message .= "";
      case "group_create":
        $message .= "";
      case "group_destroy":
        $message .= "";
      case "group_rename":
        $message .= "";
      case "repository_update":
        $message .= "Repository update\n\n" . $entityBodyObj->project->web_url;
      case "push":
        if (!empty($entityBodyObj->commits)) {
          $message .= $entityBodyObj->user_username . " pushed to branch " . $entityBodyObj->ref . " of " . $entityBodyObj->project->path_with_namespace;
          $message .= "\n\nCommits:\n";
          foreach ($entityBodyObj->commits as $commit) {
            $message .= "Message: " . $commit->message . " (Compare changes " . $commit->url . ")\n\n";
          }
        }
        break;
      case "merge_request":
        $message .= $entityBodyObj->user->name . " merge request " . $entityBodyObj->project->path_with_namespace . " (" . $entityBodyObj->object_attributes->url . ")\n\nMessage: " . $entityBodyObj->object_attributes->last_commit->message . " (Compare changes " . $entityBodyObj->object_attributes->last_commit->url . ")";
        break;
      default:
        $message .= "";
        break;
    }

    if (!empty($message)) {
      if (isset($entityBodyObj->project->path_with_namespace) && !empty($entityBodyObj->project->path_with_namespace)) {
        $message = "Project: " . $entityBodyObj->project->path_with_namespace . "\n\n" . $message;
      }
    }

    return self::Config()->NotifyMessage($message);
  }
}