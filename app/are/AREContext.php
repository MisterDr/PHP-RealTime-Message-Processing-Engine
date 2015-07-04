<?php
/**
 * Sentence context processor
 * @author: Djenad Razic
 */

namespace app\are;


use app\base\Config;
use StanfordNLP\NERTagger;
use StanfordNLP\Parser;
use StanfordNLP\POSTagger;

class AREContext {

	/**
	 * @var POSTagger
	 */
	protected $pos_tagger;

	/**
	 * @var NERTagger
	 */
	protected $ner_tagger;

	/**
	 * @var Parser
	 */
	protected $parser;

	/**
	 * Parsing result
	 * @var array
	 */
	protected $content = array();

	public function __construct()
	{
		$config = new Config();
		$base_path = $config->getBasePath() .  '/';

		$parser_path =  $base_path . Config::PARSER_PATH;
		$ner_path = $base_path . Config::NER_PATH;
		$pos_path = $base_path . Config::POS_PATH;

		$this->ner_tagger =  new NERTagger( $ner_path . 'classifiers/english.all.3class.distsim.crf.ser.gz', $ner_path . 'stanford-ner.jar' );
		$this->parser = new Parser( $parser_path . 'stanford-parser.jar', $parser_path . 'stanford-parser-3.5.2-models.jar');
		$this->pos_tagger = new POSTagger( $pos_path . 'models/english-left3words-distsim.tagger', $pos_path . 'stanford-postagger.jar');
	}

	/**
	 * Parse whole sentence
	 *
	 * @author Djenad Razic
	 * @param $sentence
	 * @return array
	 */
	public function parse($sentence)
	{
		$this->content = array_merge($this->content, $this->parser->parseSentence($sentence));
		return $this->content;
	}

	/**
	 * Named Entity Recognize
	 *
	 * @author Djenad Razic
	 * @param $sentence
	 * @return array
	 */
	protected function nerTag($sentence)
	{
		$this->content['ner'] = $this->ner_tagger->tag(explode(' ', $sentence));
		return $this->content;
	}

	/**
	 * Pos tag
	 *
	 * @param $sentence
	 * @author Djenad Razic
	 * @return array
	 */
	public function posTag($sentence)
	{
		$this->content['wordsAndTags'] = $this->pos_tagger->tag(explode(' ', $sentence));
		return $this->content;
	}
}