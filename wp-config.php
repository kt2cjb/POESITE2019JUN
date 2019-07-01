<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86 
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力してもかまいません。
 *
 * @package WordPress
 */

// 注意: 
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'poesite');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'admin');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'PointEdge01');

/** MySQL のホスト名 */
define('DB_HOST', 'localhost');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8mb4');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ihKil3dSHFZeuTO}{k2{x86|Cc~d_,-bcNT%F:@8;8SV!_)Vu^/9X<2(TA1[3p`e');
define('SECURE_AUTH_KEY',  'qPvG`i~9:VJd=>a7e;=&]`TFdm2%NbZYFsQb~TVWdRSLYrq(m=BYbBpBv(2w8Y>I');
define('LOGGED_IN_KEY',    'XGabsj]!^V&C2#EPx^&k.Dy9U/IuF^S7)eum>/r$;JG$D`pL$>*[UZ7!0>D!;}9u');
define('NONCE_KEY',        'iPB>M$lhcoE/$B=WsSi[;+=-0{hM~$yeq{CTU<P>1t$4y+BM=_[u:7+X|C0cC]MH');
define('AUTH_SALT',        'Vh)Ys`}A>WDGN+oE#YTZ&!YF.dEtF(7r/HG5idwnh|?<dy{D``@U|Td/SnX){ON:');
define('SECURE_AUTH_SALT', 'd%eI66A!az30i^/k3d_rcK+E`}x%j2eEBYL=d+Es_,t;,Z8<sT^~I6/1_gQsOR%C');
define('LOGGED_IN_SALT',   '%VFo,MILsV~eOSw]/}lQ7Pad>0:?bn:;4QgK2%euz65m<7AV,:ywz3fz^:INwl_n');
define('NONCE_SALT',       'aQAvTu#m9;/*5Qzj#Q[JbAZ4#!>Ju5$>Red.{9`on5@1p3%}~rz-y+O mM7_o}0%');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 */
define('WP_DEBUG', false);

#define('WP_ALLOW_MULTISITE', true);
define('FORCE_SSL_ADMIN', true);
#define('WP_CACHE', true);

define('FS_METHOD', 'ftpsockets');
define('FTP_HOST', 'localhost');
define('FTP_USER', 'kusanagi');
#define('FTP_PASS', '*****');

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
