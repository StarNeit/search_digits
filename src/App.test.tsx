import React from 'react';
import { render } from '@testing-library/react';
import App from './App';

describe('app', () => {
  it('renders app', async () => {
    const wrapper = render(<App />);
    expect(wrapper).toBeTruthy();
  });
});
