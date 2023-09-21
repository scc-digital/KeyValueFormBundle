<?php

declare(strict_types=1);

namespace Scc\KeyValueFormBundle\Form\Type;

use Scc\KeyValueFormBundle\Form\DataTransformer\HashToKeyValueArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KeyValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new HashToKeyValueArrayTransformer());

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $e) {
            $input = $e->getData();

            if (null === $input) {
                return;
            }

            $output = [];

            foreach ($input as $key => $value) {
                $output[] = array(
                    'key' => $key,
                    'value' => $value
                );
            }

            $e->setData($output);
        }, 1);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'entry_type' => KeyValueRowType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'key_type' => TextType::class,
            'key_options' => [],
            'value_options' => [],
            'allowed_keys' => null,
            'use_container_object' => false,
            'entry_options' => function(Options $options) {
                return array(
                    'key_type' => $options['key_type'],
                    'value_type' => $options['value_type'],
                    'key_options' => $options['key_options'],
                    'value_options' => $options['value_options'],
                    'allowed_keys' => $options['allowed_keys']
                );
            }
        ]);

        $resolver->setRequired(['value_type']);

        $resolver->setAllowedTypes('allowed_keys', ['null', 'array']);
    }

    public function getParent(): string
    {
        return CollectionType::class;
    }
}
