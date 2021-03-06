Welcome to Payments Hub's documentation!
========================================

.. toctree::
   :maxdepth: 2
   :caption: Contents:

What is Payments Hub?
---------------------

Payments Hub is a free and open-source framework for voluntary payment integration into different publishing channels
based on `Symfony Framework`_.

.. note::

    This documentation assumes you have already a working knowledge of the Symfony
    Framework. If you're not familiar with Symfony, please start with
    reading the `Quick Tour`_ from the Symfony documentation.

Features
--------

- Pay using Paypal Express Checkout, Stripe Checkout, Credit Card, SEPA Direct Debit, Mbe4 phone bill, offline.
- Recurring & non-recurring subscriptions
- Manage and add custom payment methods
- Customization of the templates
- Possibility to change the application flows (redirect URLs)
- Push details of the subscription to 3rd party applications using webhooks
- API-centric architecture

Getting Started
===============

.. toctree::
    :hidden:

    ../setup

Installation:

.. toctree::
    :hidden:

    installation/index

.. include:: /installation/map.rst.inc

Subscriptions:

.. toctree::
    :hidden:

    subscriptions/index

.. include:: /subscriptions/map.rst.inc

Payments:

.. toctree::
    :hidden:

    payments/index

.. include:: /payments/map.rst.inc

Custom Redirect URLs:

.. toctree::
    :hidden:

    custom_routes/index

.. include:: /custom_routes/map.rst.inc

Overriding templates:

.. toctree::
    :hidden:

    templates/index

.. include:: /templates/map.rst.inc

:doc:`Payum extensions <extensions/index>`

.. toctree::
    :hidden:

    extensions/index

API Documentation:

    API Documentaton can be found at http://hub-docs.s-lab.sourcefabric.org.

:doc:`How to Run Tests? <tests/index>`

:doc:`How to Translate the Payments Hub? <translations/index>`

.. toctree::
    :hidden:

    tests/index
    translations/index

.. _`Symfony Framework`: http://symfony.com
.. _`Quick Tour`: http://symfony.com/doc/current/quick_tour
