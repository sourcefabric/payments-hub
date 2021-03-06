<?php

declare(strict_types=1);

namespace PH\Bundle\PayumBundle\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Symfony\Reply\HttpResponse;
use Payum\Core\Exception\LogicException;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Model\BankAccountInterface;
use Payum\Core\Request\RenderTemplate;
use PH\Bundle\PayumBundle\Factory\BankAccountFormFactoryInterface;
use PH\Bundle\PayumBundle\Request\ObtainBankAccount;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class ObtainBankAccountAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * @var BankAccountFormFactoryInterface
     */
    protected $bankAccountFormFactory;

    /**
     * @var RequestStack
     */
    protected $httpRequestStack;

    /**
     * @var string
     */
    protected $templateName;

    /**
     * ObtainBankAccountAction constructor.
     *
     * @param BankAccountFormFactoryInterface $bankAccountFormFactory
     * @param string                          $templateName
     */
    public function __construct(BankAccountFormFactoryInterface $bankAccountFormFactory, string $templateName)
    {
        $this->bankAccountFormFactory = $bankAccountFormFactory;
        $this->templateName = $templateName;
    }

    /**
     * @param RequestStack|null $requestStack
     */
    public function setRequestStack(?RequestStack $requestStack)
    {
        $this->httpRequestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     *
     * @param ObtainBankAccount $request
     *
     * @throws \Payum\Core\Bridge\Symfony\Reply\HttpResponse
     * @throws \Payum\Core\Exception\LogicException
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);
        $httpRequest = $this->httpRequestStack->getMasterRequest();

        if (false == $httpRequest) {
            throw new LogicException('The action can be run only when http request is set.');
        }

        if (!isset($request->getModel()['type'])) {
            throw new LogicException('The type is not defined.');
        }

        $form = $this->bankAccountFormFactory->createBankAccountForm($request->getModel()['type']);

        $form->handleRequest($httpRequest);
        if ($form->isSubmitted()) {
            /** @var BankAccountInterface $bankAccount */
            $bankAccount = $form->getData();

            if ($form->isValid()) {
                $request->set($bankAccount);

                return;
            }
        }

        $renderTemplate = new RenderTemplate($this->templateName, [
            'model' => $request->getModel(),
            'firstModel' => $request->getFirstModel(),
            'form' => $form->createView(),
            'actionUrl' => $request->getToken() ? $request->getToken()->getTargetUrl() : null,
        ]);

        $this->gateway->execute($renderTemplate);

        throw new HttpResponse(new Response($renderTemplate->getResult(), 200, [
            'Cache-Control' => 'no-store, no-cache, max-age=0, post-check=0, pre-check=0',
            'X-Status-Code' => 200,
            'Pragma' => 'no-cache',
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return $request instanceof ObtainBankAccount;
    }
}
