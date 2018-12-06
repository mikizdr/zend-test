<?php
// This loop reads value for every node and child of that node
            // for ($i = 0; $i < count($this->nodes); $i++) {
            //     if ($element->{$this->nodes[$i]}->count() > 0) {
            //         $node = $element->{$this->nodes[$i]};

            //         $countryMarkets = [];

            //         foreach ($node->children() as $child) {
            //             if ($this->node_attribute) {
            //                 $countryMarkets[] = (string)$child->attributes()['Value'];
            //             } else {
            //                 $countryMarkets[] = (string)$child;
            //             }
            //         }

            //         $files[$k][$this->nodes[$i]] = $countryMarkets;
            //     }
            // }
$str = 'features?';


// if (count($node) > 0) {
                    //     foreach ($node as $a => $parent) {
                    //         if (count($parent) > 0) {
                    //             foreach ($parent as $b => $child) {
                    //                 if (count($child) > 0) {
                    //                     foreach ($child as $c => $grandchild) {
                    //                         if (count($grandchild) > 0) {
                    //                             foreach ($grandchild as $d => $grandgrandchild) {
                    //                                 $countryMarkets[] = (string)$grandgrandchild . 'GRAND GRAND CHILD';
                    //                             }
                    //                         } else {
                    //                             if ($this->node_attribute) {
                    //                                 $countryMarkets[] = (string)$grandchild->attributes()['Value'] . $str; // Hard coded
                    //                             } else {
                    //                                 $countryMarkets[] = (string)$grandchild;
                    //                             }
                    //                             // $countryMarkets[] = (string)$grandchild . 'ELSE GRAND CHILD';
                    //                         }
                    //                     }
                    //                 } else {
                    //                     if ($this->node_attribute) {
                    //                         $countryMarkets[] = (string)$child->attributes()['Value'] . $str; // Hard coded
                    //                     } else {
                    //                         $countryMarkets[] = (string)$child;
                    //                     }
                    //                     // $countryMarkets[] = (string)$child . 'ELSE CHILD';
                    //                 }
                    //             }
                    //         } else {
                    //             if ($this->node_attribute) {
                    //                 $countryMarkets[] = (string)$parent->attributes()['Value'] . $str; // Hard coded
                    //             } else {
                    //                 $countryMarkets[] = (string)$parent;
                    //             }
                    //             // $countryMarkets[] = (string)$child . 'ELSE PARENT';
                    //         }
                    //     }
                    // } else {
                    //     // foreach ($node->children() as $child) {
                    //     if ($this->node_attribute) {
                    //             // if (count($node) > 1) {
                    //         $countryMarkets[] = (string)$node->attributes()['Value'] . $str; // Hard coded
                    //     } else {
                    //         $countryMarkets[] = (string)$node;
                    //     }
                    //     // }
                    // }



                    // if (count($node) > 1) {
                    //     foreach ($node as $a => $parent) {
                    //         if (count($parent) > 1) {
                    //             echo ('<h1>parent ' . $a . ' ' . count($parent)) . '</h1>';
                    //             foreach ($parent as $b => $child) {
                    //                 // echo ('<h1>Child ' . $b . ' ' . count($child)) . '</h1>';
                    //                 // if (count($child) > 1) {
                    //                 //     foreach ($child as $c => $kid) {
                    //                 //         $countryMarkets[][$c] = (string)$kid . 'KIDMILKA';
                    //                 //     }
                    //                 // } else {
                    //                 // var_dump($child);
                    //                 $countryMarkets[][$child->getName()] = (string)$child . 'CHILDMILKA';
                    //                 // $countryMarkets[][strval($child->attributes()->lang)] = (string)$child . 'CHILDMILKA';
                    //                 // }
                    //             }
                    //         } else {
                    //             foreach ($parent as $key => $child) {
                    //                 echo ('<h1>Else ' . $a . ' ' . count($parent)) . '</h1>';
                    //                 if (count($child) > 1) {
                    //                     foreach ($parent as $key => $kid) {
                    //                         $countryMarkets[] = (string)$kid . 'KIDlea';
                    //                     }
                    //                 } else {
                    //                     $countryMarkets[][$child->getName()] = (string)$child . 'parentlea';
                    //                 }
                    //             }
                    //         }
                    //     }
                    // } else {
                    //     foreach ($node->children() as $child) {
                    //         if ($this->node_attribute) {
                    //             // if (count($node) > 1) {
                    //             $countryMarkets[] = (string)$child->attributes()['Value'] . $str; // Hard coded
                    //         } else {
                    //             $countryMarkets[] = (string)$child;
                    //         }
                    //     }
                    // }