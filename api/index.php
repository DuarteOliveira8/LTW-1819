<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

if ($request_uri[0][strlen($request_uri[0])-1] == '/')
  $path = substr($request_uri[0], 0, strlen($request_uri[0])-1);
else
  $path = $request_uri[0];

switch ($path) {
  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)$#', $path, $matches) ? true : false):
    require 'user-endpoint/User.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/posts$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserPosts.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/comments$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserComments.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/subscribe$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserSubs.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/votes$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserVotes.php';
    break;

  case '/api/user/upvotes':
    require 'user-endpoint/UserUpvotes.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/downvotes$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserDownvotes.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/password$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserPassword.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/avatar$$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserAvatar.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/channels$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserChannels.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/create-channel$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserChannelCreate.php';
    break;

  case "/api/home/main-channels":
    require 'home-endpoint/MainChannels.php';
    break;

  case "/api/home/recent-posts":
    require 'home-endpoint/RecentPosts.php';
    break;

  case (preg_match('#^/api/channel/(?P<channel>[a-zA-Z0-9-_]+)$#', $path, $matches) ? true : false):
    require 'channel-endpoint/Channel.php';
    break;

  case (preg_match('#^/api/channel/(?P<channel>[a-zA-Z0-9-_]+)/posts$#', $path, $matches) ? true : false):
    require 'channel-endpoint/ChannelPosts.php';
    break;

  case (preg_match('#^/api/channel/(?P<channel>[a-zA-Z0-9-_]+)/rules$#', $path, $matches) ? true : false):
    require 'channel-endpoint/ChannelRules.php';
    break;

  case (preg_match('#^/api/channel/(?P<channel>[a-zA-Z0-9-_]+)/(?P<creator>[a-zA-Z0-9-_]+)/update$#', $path, $matches) ? true : false):
    require 'channel-endpoint/ChannelUpdate.php';
    break;

  case (preg_match('#^/api/channel/(?P<channel>[a-zA-Z0-9-_]+)/(?P<author>[a-zA-Z0-9-_]+)/create-post#', $path, $matches) ? true : false):
    require 'channel-endpoint/ChannelPostCreate.php';
    break;

  case (preg_match('#^/api/search/(?P<search>[a-zA-Z0-9-_]+)$#', $path, $matches) ? true : false):
    require 'search-endpoint/search.php';
    break;
    
  case (preg_match('#^/api/post/(?P<id>[0-9]+)$#', $path, $matches) ? true : false):
    require 'post-endpoint/Post.php';
    break;

  case (preg_match('#^/api/post/(?P<id>[0-9]+)/comments$#', $path, $matches) ? true : false):
    require 'post-endpoint/PostComments.php';
    break;

  case (preg_match('#^/api/post/(?P<username>[a-zA-Z0-9-_]+)/vote$#', $path, $matches) ? true : false):
    require 'post-endpoint/PostVote.php';
    break;

  case (preg_match('#^/api/post/(?P<username>[a-zA-Z0-9-_]+)/upvote$#', $path, $matches) ? true : false):
    require 'post-endpoint/PostUpvote.php';
    break;

  case (preg_match('#^/api/post/(?P<username>[a-zA-Z0-9-_]+)/downvote$#', $path, $matches) ? true : false):
    require 'post-endpoint/PostDownvote.php';
    break;

  case (preg_match('#^/api/comment/(?P<id>[0-9]+)$#', $path, $matches) ? true : false):
    require 'comment-endpoint/Comment.php';
    break;

  case (preg_match('#^/api/comment/(?P<id>[0-9]+)/replies$#', $path, $matches) ? true : false):
    require 'comment-endpoint/CommentReplies.php';
    break;

  case (preg_match('#^/api/comment/(?P<username>[a-zA-Z0-9-_]+)/upvote#', $path, $matches) ? true : false):
    require 'comment-endpoint/CommentUpvote.php';
    break;

  case (preg_match('#^/api/comment/(?P<username>[a-zA-Z0-9-_]+)/downvote#', $path, $matches) ? true : false):
    require 'comment-endpoint/CommentDownvote.php';
    break;

  case (preg_match('#^/api/comment/(?P<username>[a-zA-Z0-9-_]+)/vote#', $path, $matches) ? true : false):
    require 'comment-endpoint/CommentVote.php';
    break;

  default:
    echo json_encode([
      'success' => false,
      'error' => '404_not_found'
    ]);
    break;
}
?>
