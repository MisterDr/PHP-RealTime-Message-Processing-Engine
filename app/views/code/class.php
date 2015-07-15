<?="<?PHP\r\n" ?>
<? if (isset($root['comment'])): ?>
/**
<? foreach ($root['comment'] as $comment) :?>
 * <?= $comment."\r\n" ?>
<? endforeach ?>
 */

<? endif ?>
<? if (isset($root['namespace'])): ?>
namespace <?= $root['namespace'] ?>;
<? endif ?>

<? if (isset($root['references'])): ?>
<? foreach ($root['references'] as $reference) :?>
use <?= $reference ?>;
<? endforeach ?>
<? endif ?>

class <?= $className ?><?= ! empty($root['extends']) ? " extends ".implode(', ', $root['extends']) : '' ?><?= ! empty($root['implementations']) ? " implements ".implode(', ', $root['implementations']) : '' ?> {
<? if (isset($root['constants'])): ?>
<? foreach ($root['constants'] as $key => $value) :?>
<?= "\tconst ".$key ?> = <?= $value."\r\n" ?>;
<? endforeach ?>
<? endif ?>
<? if (isset($root['properties'])): ?>
<? foreach ($root['properties'] as $key => $value) :?>
<?= "\t".$value['type'] ?> <?= '$'.$key ?> = <?= $value['value']."\r\n" ?>;
<? endforeach ?>
<? endif ?>
<? if (isset($root['methods'])): ?>
<? foreach ($root['methods'] as $methodName => $value) :?>
<? if (isset($value['comment'])): ?>
<?= "\t/**\r\n" ?>
<? foreach ($value['comment'] as $comment) :?>
<?= "\t* ".$comment."\r\n" ?>
<? endforeach ?>
<?= "\t*/\r\n" ?>
<? endif ?>
<?= "\t".implode(' ', $value['types']) ?> <?= "function ".$methodName."(" ?>
<?= \app\base\helpers\StringHelper::implodeKvp($value['parameters'], '$').")\r\n" ?>
<?= "\t{\r\n" ?>
<? foreach ($value['body'] as $body) :?>
<?="\t\t".$body."\r\n" ?>
<? endforeach ?>
<?= "\t}\r\n\r\n" ?>
<? endforeach ?>
<? endif ?>
}