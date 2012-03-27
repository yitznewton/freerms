<?php
require_once dirname(__FILE__).'/ReportsFunctionalTestCase.php';

class functional_reports_defaultActionsTest extends ReportsFunctionalTestCase
{
  public function testDatabase_DisplaysFilters()
  {
    $this->getBrowser()->
      get('/database/2')->

      with('request')->begin()->
        isParameter('module', 'default')->
        isParameter('action', 'database')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('aside.filters', true)->
      end()
    ;
  }

  public function testDatabase_DateFiltersOneYear_CorrectNumberOfColumns()
  {
    $this->getBrowser()->
      get('/database/2?timestamp[from][year]=2012&timestamp[from][month]=1'
          . '&timestamp[to][year]=2012&timestamp[to][month]=12')->

      with('request')->begin()->
        isParameter('module', 'default')->
        isParameter('action', 'database')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('thead th', 14)->
      end()
    ;
  }

  public function testDatabase_DateFiltersTwoYears_CorrectNumberOfColumns()
  {
    $this->getBrowser()->
      get('/database/2?timestamp[from][year]=2011&timestamp[from][month]=1'
          . '&timestamp[to][year]=2012&timestamp[to][month]=12')->

      with('request')->begin()->
        isParameter('module', 'default')->
        isParameter('action', 'database')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('thead th', 26)->
      end()
    ;
  }

  public function testDatabase_DateFiltersPartialYears_CorrectNumberOfColumns()
  {
    $this->getBrowser()->
      get('/database/2?timestamp[from][year]=2009&timestamp[from][month]=7'
          . '&timestamp[to][year]=2012&timestamp[to][month]=6')->

      with('request')->begin()->
        isParameter('module', 'default')->
        isParameter('action', 'database')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('thead th', 38)->
      end()
    ;
  }

  public function testDatabase_DateFiltersOneMonth_CorrectNumberOfColumns()
  {
    $this->getBrowser()->
      get('/database/2?timestamp[from][year]=2012&timestamp[from][month]=1'
          . '&timestamp[to][year]=2012&timestamp[to][month]=1')->

      with('request')->begin()->
        isParameter('module', 'default')->
        isParameter('action', 'database')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('thead th', 3)->
      end()
    ;
  }

  public function testDatabase_ColumnTotals_CorrectSum()
  {
    $b = $this->getBrowser();
    $b->get('/database/1');

    $dom = $b->getResponseDom();

    $xpath = new DOMXpath($dom);

    $sum = 0;

    foreach ($xpath->query('//tbody/tr/td[position()=2]') as $cell) {
      $sum += (int) $cell->nodeValue;
    }

    $this->assertEquals((int) $xpath->query('//tfoot/tr/td[position()=2]')
      ->item(0)->nodeValue, $sum);
  }

  public function testDatabase_RowTotals_CorrectSum()
  {
    $b = $this->getBrowser();
    $b->get('/database/1');

    $dom = $b->getResponseDom();

    $xpath = new DOMXpath($dom);

    $sum = 0;

    foreach ($xpath->query('//tbody/tr[position()=0]/td') as $cell) {
      $sum += (int) $cell->nodeValue;
    }

    $totalCell = $xpath->query('//tbody/tr[position()=0]/th[@class="total"]');

    // position + 1: skip blank corner cell
    $this->assertEquals((int) $totalCell->nodeValue, $sum);
  }

  public function testDatabase_MobileTotals_Equal100()
  {
    $b = $this->getBrowser();
    $b->get('/database/1');

    $dom = $b->getResponseDom();

    $xpath = new DOMXpath($dom);

    $ddSum = 0;

    foreach ($xpath->query('//section[@class="mobile-share"]/dl/dd') as $dd) {
      $ddSum += (int) preg_replace('/[^\d\.]/', '', $dd->nodeValue);
    }

    $this->assertTrue($ddSum - 100 < 1);
  }

  public function testDatabase_OnsiteTotals_Equal100()
  {
    $b = $this->getBrowser();
    $b->get('/database/1');

    $dom = $b->getResponseDom();

    $xpath = new DOMXpath($dom);

    $ddSum = 0;

    foreach ($xpath->query('//section[@class="onsite-share"]/dl/dd') as $dd) {
      $ddSum += (int) preg_replace('/[^\d\.]/', '', $dd->nodeValue);
    }

    $this->assertTrue($ddSum - 100 < 1);
  }
}

