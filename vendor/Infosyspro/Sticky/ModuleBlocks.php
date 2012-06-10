<?php

namespace Infosyspro\Sticky;
/*
 * This is a template processor e.g
 * <table><odoc:foreach>
 *     <tr><td>test</td></tr>
 *    <odoc:if expr="davidoa -eq [[lastname]]">
 *     <td>[[lastname]]</td> </odoc:endif>
 *     <odoc:elseif expr="Infosyspro -eq [[company]]">
 *     <td>[[company]]</td>
 *     </odoc:endelseif>
 *     <odoc:else>
 *     <td>nothing here</td>
 *     </odoc:endelse>
 *     </odoc:endforeach> </table>';
 * Usage:
 *  $tpl = new Template(array('tpl' => $tpl, 'databaseResult'=>$dbData);
 *  echo $tpl->render();
 * 
 */


class ModuleBlocks {

    protected $operators = array('-eq', '-ne', '-lt', '-le', '-gt', '-ge',);
    protected $tpl;

    /* Container for processed foreach */
    protected $foreachData = array();
    protected $dbData = array();

    /**
     * Process template from the database
     *   $dbData = array();
     *   $dbData['lastname'] = 'davido';
     *   $dbData['passowrd'] = 'dailer00';
     *   $dbData['company'] = 'Infosyspro';
     *   $dbData['email'] = 'davido@test.com';
     * 
     * @param array $data
     * @param string $tpl 
     */
    public function __construct(Array $data= null) {  
        if(!isset($data['tpl'])) return false;
        
        $this->tpl = $data['tpl'];
        unset($data['tpl']);
        $this->dbData = $data;
        /* Remove tabs, returns etc */
        $this->tpl = str_replace(array("\s", "\n", "\r"), '', $this->tpl);
    }

    /**
     * Render the tempalte 
     * @return string 
     */
    public function render() {

        $code = array();
        $search = array();
        /* Check if foreach has matched */
        if ($this->checkForeach()) {
            $foreachContent = '';
            /* Process an array to process the template */
            foreach ($this->dbData as $k => $data) {

                if (isset($this->data['foreachIf'])) {
                    $expr = str_replace(array('"', ' '), ' ', $this->data['foreachIfExpr']);
                    if ($if = $this->checkReplace($data, $expr)) {
                        $expr = $if;
                    }
                    $data['expr'] = $expr;
                    $data['condType'] = $this->data['foreachIfContent'];
                    if ($stmt = $this->processConditions($data)) {
                        $ifc['foreachIf'] .= $stmt;
                    } elseif (isset($this->data['foreachElseIf'])) {
                        $data['condType'] = $this->data['foreachElseIfContent'];
                        $expr = str_replace(array('"', ' '), '', $this->data['foreachElseIfExpr']);
                        if ($elseIf = $this->checkReplace($data, $expr)) {
                            $expr = $elseIf;
                        }
                        $data['expr'] = $expr;
                        if ($stmt = $this->processConditions($data)) {
                            $ifc['foreachElseIf'] .= $stmt;
                        } elseif (isset($this->data['foreachElse'])) {
                            $ifc['foreachElse'] .= $this->checkReplace($data, $this->data['foreachElseContent']);
                        }
                    } elseif (isset($this->data['foreachElse'])) {
                        $ifc['foreachElse'] .= $this->checkReplace($data, $this->data['foreachElseContent']);
                    }
                }
            }
            /* Replace foreach */
            //  if(!empty($foreachContent))
            $contentReplace = array('code' => array($this->data['foreachIf'], $this->data['foreachElseIf'], $this->data['foreachElse']),
                'replace' => '',
                'data' => $this->data['foreachContent'],
            );

            $search = array('code' => array($this->data['foreachIf'], $this->data['foreachElseIf'], $this->data['foreachElse']),
                'replace' => $ifc,
                'data' => $this->data['foreachContent'],
            );
            $content = $this->replaceAll($contentReplace);

            $foreachResult = $this->replaceAll($search);
            $this->tpl = str_replace($this->data['foreach'], $foreachResult, $this->tpl);
        } elseif ($this->checkIf()) { /* Check if we have set the If statement */
            $ifContent = '';
            $data = $this->dbData[0];
            /* Only if is set so let check all the process for if */
            if (isset($this->data['if'])) {
                $expr = str_replace(array('"', ' '), ' ', $this->data['ifExpr']);
                if ($if = $this->checkReplace($data, $expr)) {
                    $expr = $if;
                }
                $data['expr'] = $expr;
                $data['condType'] = $this->data['ifContent'];

                if ($stmt = $this->processConditions($data)) {
                    $ifc['if'] .= $stmt;
                } elseif (isset($this->data['elseIf'])) {
                    $data['condType'] = $this->data['elseIfContent'];
                    $expr = str_replace(array('"', ' '), '', $this->data['elseIfExpr']);
                    if ($elseIf = $this->checkReplace($data, $expr)) {
                        $expr = $elseIf;
                    }
                    $data['expr'] = $expr;

                    if ($stmt = $this->processConditions($data)) {
                        $ifc['elseIf'] .= $stmt;
                    } elseif (isset($this->data['else'])) {
                        $ifc['else'] .= $this->checkReplace($data, $this->data['elseContent']);
                    }
                } elseif (isset($this->data['else'])) {
                    $ifc['else'] .= $this->checkReplace($data, $this->data['elseContent']);
                }

                $contentReplace = array('code' => array($this->data['if'], $this->data['elseIf'], $this->data['else']),
                    'replace' => $ifc,
                    'data' => $this->tpl,
                );
                $this->tpl = $this->replaceAll($contentReplace);
            }
        } else {
            /* process the whole thing no expressions set */
            $this->tpl = $this->checkReplace($this->dbData[0], $this->tpl);
        }
        return $this->tpl;
    }

    /**
     * Replace all [[?]] with a str_replace wrapper
     * 
     * @param array  $search
     * @return string 
     */
    protected function replaceAll($search) {
        $content = '';
        $content .= str_replace($search['code'], $search['replace'], $search['data']);

        return $content;
    }

    /**
     * 
     * @param type $cond 
     */
    protected function processIfCondition($cond) {
        if (isset($this->data[$cond[0]])) {
            $expr = str_replace(array('"', ' '), '', $data['ifExpr']);
            if ($if = $this->checkReplace($expr, $data)) {
                $expr = $if;
            }
            $content .= $this->processConditions($expr);
        } elseif (isset($this->data['elseIf'])) {

            $expr = str_replace(array('"', ' '), '', $data['elseIfExpr']);
            if ($elseIf = $this->checkReplace($expr, $data)) {
                $expr = $elseIf;
            }
            $content .= $this->processConditions($expr);
        } elseif (isset($this->data['else'])) {
            $content .= $this->checkReplace($this->data['ifContent']);
        }
    }

    /**
     * Check if foreach has been created from the template
     * 
     * @return bool
     */
    protected function checkForeach() {
        if (preg_match('/<odoc:foreach>(.*?)<\/odoc:endforeach>/', $this->tpl, $matches)) {
            $this->data['foreach'] = $matches[0];
            $this->data['foreachContent'] = $matches[1];

            if (preg_match('/<odoc:if.*?(["].*?)>(.*?)<\/odoc:endif>/', $matches[1], $matchesif)) {
                $this->data['foreachIf'] = $matchesif[0];
                $this->data['foreachIfExpr'] = $matchesif[1];
                $this->data['foreachIfContent'] = $matchesif[2];
                if (preg_match('/<odoc:elseif.*?(["].*?)>(.*?)<\/odoc:endelseif>/', $matches[1], $matcheselseif)) {
                    $this->data['foreachElseIf'] = $matcheselseif[0];
                    $this->data['foreachElseIfExpr'] = $matcheselseif[1];
                    $this->data['foreachElseIfContent'] = $matcheselseif[2];
                }
                if (preg_match('/<odoc:else>(.*?)<\/odoc:endelse>/', $matches[1], $matcheselse)) {
                    $this->data['foreachElse'] = $matcheselse[0];
                    $this->data['foreachElseContent'] = $matcheselse[1];
                }
            }
        }
        if (isset($this->data['foreach'])) {
            return true;
        }
        return false;
    }

    /**
     *  Check if IF has been set within the template passed
     * @return bool
     */
    protected function checkIf() {

        if (preg_match('/<odoc:if.*?(["].*?)>(.*?)<\/odoc:endif>/', $this->tpl, $matchesif)) {

            $this->data['if'] = $matchesif[0];
            $this->data['ifExpr'] = $matchesif[1];
            $this->data['ifContent'] = $matchesif[2];

            if (preg_match('/<odoc:elseif.*?(["].*?)>(.*?)<\/odoc:endelseif>/', $this->tpl, $matcheselseif)) {
                $this->data['elseIf'] = $matcheselseif[0];
                $this->data['elseIfExpr'] = $matcheselseif[1];
                $this->data['elseIfContent'] = $matcheselseif[2];
            }
            if (preg_match('/<odoc:else>(.*?)<\/odoc:endelse>/', $this->tpl, $matcheselse)) {
                $this->data['else'] = $matcheselse[0];
                $this->data['elseContent'] = $matcheselse[1];
            }
        }
        if (isset($this->data['if'])) {
            return true;
        }
        return false;
    }

    /**
     * Replace data within the [[*]]
     *
     * @param array $data
     * @return mixture bool|string
     */
    protected function checkReplace($data, $expr = '') {
        if (empty($expr)) {
            $expr = $data['condType'];
        }

        if (!preg_match_all('/\[\[(.+?)\]\]/', $expr, $results)) {
            return $expr;
        }

        $replace = $results[0];
        $with = array();
        foreach ($results[1] as $result) {
            if (array_key_exists($result, $data)) {
                $with[] = $data[$result];
            } else {
                $with[] = '';
            }
        }

        return str_replace($replace, $with, $expr);
    }

    /**
     * Get assignment operator:  This returns the following as an array key
     * n1 eq n2      Check to see if n1 equals n2.
     * n1 ne n2      Check to see if n1 is not equal to n2.
     * n1 lt n2      Check to see if n1 < n2.
     * n1 le n2      Check to see if n1 <= n2.
     * n1 gt n2      Check to see if n1 > n2.
     * n1 ge n2      Check to see if n1 >= n2.
     * @param string $string
     * @return array
     */
    protected function getAssignmentOperator($string) {

        $opGroups = array();

        foreach ($this->operators as $ops) {
            $operator = explode($ops, $string);
            if (sizeOf($operator) > 1) {
                $opGroups[$ops] = $operator;
            }
        }

        if (sizeOf($opGroups) > 0) {
            return $opGroups;
        }

        return false;
    }

    /**
     * Get AND or OR if they were set
     *
     * @param string $logical
     * @param string $string
     * @return array
     */
    protected function getLogicalOperator($logical, $string) {
        if (strtolower($logical) == '&&') {
            $and = explode('&&', $string);
            if (count($and) > 1) {
                return $and;
            }
        } else {
            $or = explode('||', $string);
            if (count($or) > 1) {
                return $or;
            }
        }
        return false;
    }

    /**
     * Process all statements
     *
     * @param atring $expr
     * @return string
     */
    protected function processConditions($data) {
        $content = '';
        /* Check if there are any logical operators set i.e. and or or */
        $logicalOpAnd = $this->getLogicalOperator('&&', $data['expr']);
        $logicalOpOr = $this->getLogicalOperator('||', $data['expr']);

        /* Process the && Logical operator */
        if ($logicalOpAnd) {
            /* Process the AND i.e.  <odoc:if expr="davido -eq [[lastname]] && oabile = [[lastname]]"> */
            if ($this->processStatement($this->getAssignmentOperator($logicalOpAnd[0])) && $this->processStatement($this->getAssignmentOperator($logicalOpAnd[1]))) {
                $content .= $this->checkReplace($data);
            }
        } else if ($logicalOpOr) { /* Process the || Logical Op */
            /* Process the OR operator i.e.  <odoc:if expr="davido -eq [[lastname]] || oabile = [[lastname]]"> */
            if ($this->processStatement($this->getAssignmentOperator($logicalOpOr[0])) || $this->processStatement($this->getAssignmentOperator($logicalOpOr[1]))) {
                $content .= $this->checkReplace($data);
            }
        } else if ($this->processStatement($this->getAssignmentOperator($data['expr']))) {
            /* Process normal IF i.e.  <odoc:if expr="davido -eq [[lastname]] "> */
            $content .= $this->checkReplace($data);
        }

        return $content;
    }

    /**
     * Check which oprator to use. The following operators are used
     *  -eq, -ne, -lt, -le, gt, ge
     * @param array $assignmentOperators
     * @return bool
     */
    protected function processStatement($assignmentOperators) {
        $assign = array_pop(array_keys($assignmentOperators));
        $assignmentOperators = array_shift($assignmentOperators);

        switch ($assign) {
            case '-eq':
                if ($assignmentOperators[0] == $assignmentOperators[1]) {
                    return true;
                }
                break;
            case '-ne' :
                if ($assignmentOperators[0] != $assignmentOperators[1]) {
                    return true;
                }
                break;
            case '-lt' :
                if ($assignmentOperators[0] < $assignmentOperators[1]) {
                    return true;
                }
                break;
            case '-le' :
                if ($assignmentOperators[0] <= $assignmentOperators[1]) {
                    return true;
                }
                break;
            case '-gt' :
                if ($assignmentOperators[0] > $assignmentOperators[1]) {
                    return true;
                }
                break;
            case '-ge' :
                if ($assignmentOperators[0] >= $assignmentOperators[1]) {
                    return true;
                }
                break;
            default :
                return false;
        }
    }

}

