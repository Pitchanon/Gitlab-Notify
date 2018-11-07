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

    switch ($entityBodyObj->event_name) {
      case "project_create":
        $message .= "";
      case "user_add_to_team":
        $message .= "";
      case "repository_update":
        $message .= "";
      case "project_update":
        $message .= "";
      case "merge_request":
        $message .= "";
      case "push":
        if (!empty($entityBodyObj->commits)) {
          $message .= $entityBodyObj->user_username . " pushed to branch " . $entityBodyObj->ref . " of " . $entityBodyObj->project->path_with_namespace . " (Compare changes " . $entityBodyObj->commits[0]->url . ")";
          $message .= "\n\nCommits:\n";
          foreach ($entityBodyObj->commits as $commit) {
            $message .= "Message: " . $commit->message . "\n\n";
          }
        }
      default:
        $message .= "";
        break;
    }

    if (!empty($message)) {
      if (isset($entityBodyObj->project->name) && !empty($entityBodyObj->project->name)) {
        $message = "Project: " . $entityBodyObj->project->name . "\n\n" . $message;
      }
    }

    return self::Config()->NotifyMessage($message);
  }
}