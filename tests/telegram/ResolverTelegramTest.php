<?php

use deflou\components\applications\AppWriter;
use deflou\components\applications\Telegram;
use deflou\components\applications\telegram\events\MessageFrom;
use deflou\components\applications\telegram\operations\MessageTo;
use deflou\components\instances\InstanceService;
use deflou\components\resolvers\operations\ResolvedOperationHttp;
use deflou\components\resolvers\ResolverTelegram;
use deflou\components\triggers\ETrigger;
use deflou\components\triggers\operations\plugins\PluginTelegramParseModes;
use deflou\components\triggers\TriggerService;
use deflou\interfaces\extensions\instances\IExtensionInstanceResolver;
use deflou\interfaces\extensions\instances\IExtensionInstanceTriggers;
use deflou\interfaces\instances\IInstance;
use deflou\interfaces\resolvers\events\IResolvedEvent;
use deflou\interfaces\resolvers\operations\IResolvedOperationHttp;
use deflou\interfaces\triggers\events\ITriggerEvent;
use deflou\interfaces\triggers\operations\ITriggerOperation;
use deflou\interfaces\triggers\operations\ITriggerOperationValue;
use extas\interfaces\parameters\IParam;
use tests\ExtasTestCase;

class ResolverTelegramTest extends ExtasTestCase
{
    protected array $libsToInstall = [
        'jeyroik/df-triggers' => ['php', 'php'],
        'jeyroik/df-applications' => ['php', 'json'],
        'jeyroik/extas-conditions' => ['php', 'json'],
        '' => ['php', 'php']
        //'vendor/l,ib' => ['php', 'json'] storage ext, extas ext
    ];
    protected bool $isNeedInstallLibsItems = true;
    protected string $testPath = __DIR__;

    public function testResolver()
    {
        $appService = new AppWriter();
        $app = $appService->createAppByConfigPath(__DIR__ . '/../../resources/application.json');
        
        $iService = new InstanceService();

        /**
         * @var IExtensionInstanceTriggers|IInstance $instance
         */
        $instance = $iService->createInstanceFromApplication($app, 'test');

        $tService = new TriggerService();
        $trigger = $tService->createTriggerForInstance($instance, 'test');

        $eventData = [
            ITriggerEvent::FIELD__NAME => Telegram::EVENT__MESSAGE_FROM->value,
            ITriggerEvent::FIELD__PARAMS => [

            ]
        ];

        $trigger->setEvent($eventData);

        $opData = [
            ITriggerOperation::FIELD__NAME => Telegram::OPERATION__MESSAGE_TO->value,
            ITriggerOperation::FIELD__PARAMS => [
                MessageTo::PARAM__PARSE_MODE->value => [
                    IParam::FIELD__NAME => MessageTo::PARAM__PARSE_MODE->value,
                    IParam::FIELD__VALUE => [
                        ITriggerOperationValue::FIELD__PLUGINS => [PluginTelegramParseModes::NAME],
                        ITriggerOperationValue::FIELD__VALUE => 'markdown'
                    ]
                ],
                MessageTo::PARAM__MESSAGE->value => [
                    IParam::FIELD__NAME => MessageTo::PARAM__MESSAGE->value,
                    IParam::FIELD__VALUE => [
                        ITriggerOperationValue::FIELD__PLUGINS => [],
                        ITriggerOperationValue::FIELD__VALUE => 'Use **markdown** parse mode'
                    ]
                ]
            ]
        ];
        $trigger->setOperation($opData);
        $tService->insertOperationInstance($trigger, $instance);

        $trigger->activate();

        /**
         * @var IInstance|IExtensionInstanceResolver $instance
         */
        $resolver = $instance->buildResolver(MessageFrom::NAME->value, [
            ResolverTelegram::PARAM__REQUEST => [
                IParam::FIELD__NAME => ResolverTelegram::PARAM__REQUEST,
                IParam::FIELD__VALUE => [
                    Telegram::TOKEN->value => '',
                    MessageFrom::PARAM__BOT_NAME->value => 'test',
                    MessageFrom::PARAM__CHAT_ID->value => 1,
                    MessageFrom::PARAM__TOPIC_ID->value => 1,
                    MessageFrom::PARAM__MESSAGE->value => 'test',
                    MessageFrom::PARAM__MESSAGE_ID->value => 1,
                    MessageFrom::PARAM__USER_FROM__USERNAME->value => 'test',
                ]
            ]
        ]);

        $resolvedEvent = $resolver->resolveEvent();
        $this->assertInstanceOf(IResolvedEvent::class, $resolvedEvent);

        $applicableCount = 0;

        if ($tService->isApplicableTrigger($resolvedEvent, $trigger)) {
            $applicableCount++;

            /**
             * @var IInstance|IExtensionInstanceResolver $opInstance
             */
            $opInstance = $trigger->getInstance(ETrigger::Operation);

            /**
             * @var ResolvedOperationHttp $resolvedOp
             */
            $resolvedOp = $opInstance->buildResolver('test_event', [])->resolveOperation($resolvedEvent, $trigger);
            
            $this->assertInstanceOf(ResolvedOperationHttp::class, $resolvedOp);

            $params = $resolvedOp->buildParams();
            $this->assertTrue($params->hasOne(IResolvedOperationHttp::PARAM__REQUEST_PARAMS));
            $this->assertTrue($params->hasOne(IResolvedOperationHttp::PARAM__REQUEST_OPTIONS));
            $this->assertTrue($params->hasOne(IResolvedOperationHttp::PARAM__REQUEST_HEADERS));
            $headers = $params->buildOne(IResolvedOperationHttp::PARAM__REQUEST_HEADERS)->getValue();
            $this->assertEquals(
                ['X-DF-BOT-TOKEN' => ''],
                $headers
            );

            $requestParams = $params->buildOne(IResolvedOperationHttp::PARAM__REQUEST_PARAMS)->getValue();
            $this->assertEquals('markdown', $requestParams[MessageTo::PARAM__PARSE_MODE->value]);

            $result = $resolvedOp->run();
            $this->assertFalse($result->isSuccess());
        }
        
        $this->assertEquals(1, $applicableCount);
    }
}
