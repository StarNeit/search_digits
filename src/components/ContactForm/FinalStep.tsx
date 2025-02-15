import PhoneInput from 'react-phone-input-2';
import { Input, Checkbox, Button } from '@material-tailwind/react';
import { Controller, useForm } from 'react-hook-form';
import clsx from 'clsx';

type ContactForm = {
  email: string;
  phone: string;
  address: string;
  termsAndCondition: boolean;
};

const FinalStep = () => {
  const {
    register,
    formState: { errors },
    handleSubmit,
    control
  } = useForm<ContactForm>({
    mode: 'onBlur',
    defaultValues: {
      email: '',
      phone: '',
      address: '',
      termsAndCondition: false
    }
  });

  const onSubmit = () => {
  };

  return (
    <div>
      <h2 className="text-xl md:text-2xl font-semibold text-black">
        Our <span className="text-red-500">Pest Control</span> experts are ready
        to help you!
      </h2>
      <p className="text-black text-sm md:text-base">
        Simply enter your details, and we’ll contact you back to confirm.
      </p>
      <div className="flex flex-col gap-3 py-3 md:py-6">
        <div>
          <Input
            type="email"
            label="Email Address"
            size="lg"
            {...register('email', {
              required: 'Please enter your email.',
              pattern: {
                value: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Please enter valid email.'
              }
            })}
            error={!!errors.email?.message}
          />
          {!!errors.email?.message && (
            <p className="text-sm text-red-500 font-semibold mt-1">
              {errors.email?.message}
            </p>
          )}
        </div>

        <div>
          <Controller
            control={control}
            name="phone"
            rules={{
              required: 'Please enter phone number.',
              pattern: {
                value: /^(\+\d{1,3}[- ]?)?\d{10}$/,
                message: 'Please enter a valid phone number.'
              }
            }}
            render={({ field: { onChange, value } }) => {
              const handleChange = (v: string) => {
                onChange(v);
              };

              return (
                <>
                  <PhoneInput
                    country={'us'}
                    containerClass={clsx(!!errors.phone?.message && 'error')}
                    value={value}
                    onChange={handleChange}
                  />
                  {!!errors.phone?.message && (
                    <p className="text-sm text-red-500 font-semibold mt-1">
                      {errors.phone?.message}
                    </p>
                  )}
                </>
              );
            }}
          />
        </div>

        <div>
          <Input
            label="Address & Post Code"
            size="lg"
            {...register('address', {
              required: 'Please enter address & Post Code'
            })}
            error={!!errors.address?.message}
          />
          {!!errors.address?.message && (
            <p className="text-sm text-red-500 font-semibold mt-1">
              {errors.address?.message}
            </p>
          )}
        </div>

        <div>
          <Checkbox
            label="I agree with the terms and condition"
            labelProps={{
              className: clsx(
                'text-sm',
                !!errors.termsAndCondition?.message && 'text-red-500'
              )
            }}
            {...register('termsAndCondition', {
              required: 'It should be agreed'
            })}
          />
        </div>
      </div>

      <div className="flex justify-end">
        <Button onClick={() => handleSubmit(onSubmit)()}>
          Get my free quote
        </Button>
      </div>
    </div>
  );
};

export default FinalStep;
