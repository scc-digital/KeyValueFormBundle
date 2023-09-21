<?php

namespace Scc\KeyValueFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KeyValueRowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (null === $options['allowed_keys']) {
            $builder->add('key', $options['key_type'], $options['key_options']);
        } else {
            $builder->add(
                'key',
                ChoiceType::class,
                array_merge([
                    'choices' => $options['allowed_keys']
                ],
                    $options['key_options']
                )
            );
        }

        $builder->add('value', $options['value_type'], $options['value_options']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'key_type' => TextType::class,
            'key_options' => [],
            'value_options' => [],
            'allowed_keys' => null
        ));

        $resolver->setRequired(['value_type']);
        $resolver->setAllowedTypes('allowed_keys', ['null', 'array']);
    }
}