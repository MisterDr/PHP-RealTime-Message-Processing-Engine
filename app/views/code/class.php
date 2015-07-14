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

class <?= $className ?> {
<? if (isset($root['constants'])): ?>

<? foreach ($root['constants'] as $key => $value) :?>
<?= "\tconst ".$key ?> = <?= $value ?>;
<? endforeach ?>

<? endif ?>
<? if (isset($root['properties'])): ?>
<? foreach ($root['properties'] as $key => $value) :?>
<?= "\t".$value['type'] ?> <?= '$'.$key ?> = <?= $value['value'] ?>;
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
<?= "\t".implode(' ', $value['types']) ?> <?= $methodName." (" ?>
<?= \app\base\helpers\StringHelper::implodeKvp($value['parameters'], '$').")\r\n" ?>
<?= "\t{\r\n" ?>
<? foreach ($value['body'] as $body) :?>
<?="\t\t".$body."\r\n" ?>
<? endforeach ?>
<?= "\t}\r\n" ?>
<? endforeach ?>
<? endif ?>
}